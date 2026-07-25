/**
 /** WebAuthn / Passkeys JS Helper for Dacin Dashboard **/

function bufferToBase64(buffer) {
    return btoa(String.fromCharCode(...new Uint8Array(buffer)))
        .replace(/\+/g, "-")
        .replace(/\//g, "_")
        .replace(/=/g, "");
}

function base64ToBuffer(base6464) {
    let base64 = base6464.replace(/-/g, "+").replace(/_/g, "/");
    while (base64.length % 4) {
        base64 += "=";
    }
    const binary = atob(base64);
    const buffer = new Uint8Array(binary.length);
    for (let i = 0; i < binary.length; i++) {
        buffer[i] = binary.charCodeAt(i);
    }
    return buffer.buffer;
}

export async function registerPasskey(options) {
    if (!window.PublicKeyCredential) {
        throw new Error("Browser Anda tidak mendukung Passkey / WebAuthn.");
    }

    const publicKeyOptions = { ...options };
    publicKeyOptions.challenge = base64ToBuffer(options.challenge);
    publicKeyOptions.user.id = base64ToBuffer(options.user.id);

    if (publicKeyOptions.excludeCredentials) {
        publicKeyOptions.excludeCredentials = publicKeyOptions.excludeCredentials.map((c) => ({
            ...c,
            id: base64ToBuffer(c.id),
        }));
    }

    const credential = await navigator.credentials.create({
        publicKey: publicKeyOptions,
    });

    return {
        id: credential.id,
        rawId: bufferToBase64(credential.rawId),
        clientDataJSON: bufferToBase64(credential.response.clientDataJSON),
        attestationObject: bufferToBase64(credential.response.attestationObject),
    };
}

export async function authenticatePasskey(options) {
    if (!window.PublicKeyCredential) {
        throw new Error("Browser Anda tidak mendukung Passkey / WebAuthn.");
    }

    const publicKeyOptions = { ...options };
    publicKeyOptions.challenge = base64ToBuffer(options.challenge);

    if (publicKeyOptions.allowCredentials) {
        publicKeyOptions.allowCredentials = publicKeyOptions.allowCredentials.map((c) => ({
            ...c,
            id: base64ToBuffer(c.id),
        }));
    }

    const credential = await navigator.credentials.get({
        publicKey: publicKeyOptions,
    });

    return {
        id: credential.id,
        rawId: bufferToBase64(credential.rawId),
        clientDataJSON: bufferToBase64(credential.response.clientDataJSON),
        authenticatorData: bufferToBase64(credential.response.authenticatorData),
        signature: bufferToBase64(credential.response.signature),
    };
}

window.WebAuthnHelper = {
    registerPasskey,
    authenticatePasskey,
};
