# import lib yg dibutuhkan
from fastapi import FastAPI, File, UploadFile, Form
from fastapi.responses import JSONResponse, RedirectResponse
import shutil, os, glob
import numpy as np
import cv2
from insightface.app import FaceAnalysis
from numpy.linalg import norm

# init app
app = FastAPI()

# inisialisasi model InsightFace
insight_app = FaceAnalysis(name="buffalo_l")
insight_app.prepare(ctx_id=0)

# tentukan folder referensi
BASE_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), "..", "public", "storage", "labels"))

@app.get("/")
async def root():
    return RedirectResponse(url="https://attendance.indodacin.com")

# inisialisasi fungsi
@app.post("/recognize")
async def recognize(kode_pegawai: str=Form(...), file: UploadFile = File(...)):
    try:
        folder_path = os.path.join(BASE_DIR, kode_pegawai)

        # verifikasi folder
        if not os.path.exists(folder_path):
            return JSONResponse({"error": "Folder referensi tidak ditemukan"}, status_code=404)

        # simpan foto upload sebagai file sementara
        temp_path = f"temp_files/temp_{file.filename}"
        with open(temp_path, "wb") as f:
            shutil.copyfileobj(file.file, f)

        # pastikan file benar-benar tersimpan dan valid
        if not os.path.exists(temp_path) or os.path.getsize(temp_path) == 0:
            return JSONResponse({"error": "Gagal menyimpan file sementara"}, status_code=400)

        # baca semua foto referensi di folder pegawai
        temp_img = cv2.imread(temp_path)
        faces = insight_app.get(temp_img)

        if not faces:
            return JSONResponse({
                "kode_pegawai": kode_pegawai,
                "verified": False,
                "distance": 1.0,
                "error": True,
                "error_message": "Tidak ada wajah yang terdeteksi pada foto"
            }, status_code=400)

        uploaded_embedding = faces[0].embedding
        matched = False
        best_distance = 1.0

        for ref_img_path in glob.glob(f"{folder_path}/*.png"):
            ref_img = cv2.imread(ref_img_path)
            ref_faces = insight_app.get(ref_img)
            if not ref_faces:
                continue

            ref_embedding = ref_faces[0].embedding
            cosine_sim = np.dot(uploaded_embedding, ref_embedding) / (norm(uploaded_embedding) * norm(ref_embedding))
            distance = 1 - cosine_sim  # konversi ke bentuk jarak (semakin kecil, semakin mirip)

            if cosine_sim > 0.5:
                matched = True
                best_distance = distance
                break

            best_distance = min(best_distance, distance)

        # hapus foto sementara
        os.remove(temp_path)

        # kembalikan hasil dengan format json
        return JSONResponse({
             "kode_pegawai": kode_pegawai,
            "verified": matched,
            "distance": float(best_distance),
            "error": False,
            "error_message": ""
        })

    except Exception as e:
        return JSONResponse({
            "kode_pegawai": kode_pegawai,
            "verified": False,
            "distance": 1.0,
            "error": True,
            "error_message": str(e)
        }, status_code=500)