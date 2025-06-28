# import lib yg dibutuhkan
from fastapi import FastAPI, File, UploadFile, Form
from fastapi.responses import JSONResponse
from deepface import DeepFace
import shutil, os, glob

# init app
app = FastAPI()

# tentukan model yg digunakan
model_name = "ArcFace"
model = DeepFace.build_model(model_name)

# tentukan folder referensi
BASE_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), "..", "public", "storage", "labels"))

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
        matched = False
        best_distance = 1.0
        objs = None

        # cek dulu ada wajah ga di foto yg ditake
        faces = DeepFace.extract_faces(temp_path, enforce_detection=False)

        if not faces:
            return JSONResponse({"error": "Tidak ada wajah terdeteksi"}, status_code=400)

        for ref_img in glob.glob(f"{folder_path}/*.png"):
            result = DeepFace.verify(
                img1_path = ref_img,
                img2_path = temp_path,
                model_name = model_name
            )

            if result["verified"]:
                matched = True
                best_distance = result["distance"]
                break

            # catat jarak terdekat (optional)
            best_distance = min(best_distance, result["distance"])

        # # analisis
        # objs = DeepFace.analyze(
        #     img_path=temp_path,
        #     actions=['age', 'gender', 'race', 'emotion'],
        #     enforce_detection=True
        # )

        # if not objs:
        #     return JSONResponse({"error": "Tidak ada wajah terdeteksi"}, status_code=400)

        # # ambil wajah terbesar jika ada banyak
        # if isinstance(objs, list):
        #     best_face = max(objs, key=lambda o: o["region"]["w"] * o["region"]["h"])
        # else:
        #     best_face = objs

        # hapus foto sementara
        os.remove(temp_path)

        # kembalikan hasil dengan format json
        return JSONResponse({
            "verified": matched,
            "distance": best_distance,
            "error": False,
            # "base_dir": BASE_DIR,
            # "folder_path": folder_path,
            # "temp_path": temp_path,
            # "age": best_face.get("age"),
            # "gender": best_face.get("dominant_gender"),
            # "race": best_face.get("dominant_race"),
            # "emotion": best_face.get("dominant_emotion")
        })

    except Exception as e:
        return JSONResponse({
            "verified": False,
            "distance": 1.0,
            "error": True,
            "error_message": str(e)}, 
        status_code=500)
