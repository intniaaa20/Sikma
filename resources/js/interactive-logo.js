import * as THREE from "three";
import { FBXLoader } from "three/examples/jsm/loaders/FBXLoader.js";

// Helper: Properti CSS yang relevan untuk disalin ke elemen cermin
const relevantCssProps = [
    "font-family",
    "font-size",
    "font-weight",
    "font-style",
    "line-height",
    "letter-spacing",
    "text-transform",
    "word-spacing",
    "text-indent",
    "text-align",
    "padding-top",
    "padding-right",
    "padding-bottom",
    "padding-left",
    "border-top-width",
    "border-right-width",
    "border-bottom-width",
    "border-left-width",
    "box-sizing",
    "white-space",
    "word-wrap",
];

// Helper: Fungsi untuk mendapatkan koordinat caret (estimasi)
let mirrorDiv = null;
function getCaretCoordinates(element) {
    const selectionStart = element.selectionStart;

    // Buat elemen cermin jika belum ada
    if (!mirrorDiv) {
        mirrorDiv = document.createElement("div");
        mirrorDiv.className = "caret-mirror-div";
        document.body.appendChild(mirrorDiv);
    }

    // Salin gaya yang relevan dari input ke div cermin
    const style = window.getComputedStyle(element);
    relevantCssProps.forEach((prop) => {
        mirrorDiv.style[prop] = style[prop];
    });
    mirrorDiv.style.width = style.width; // Pastikan lebar sama

    // Isi div cermin dengan teks hingga posisi caret
    // Untuk password, gunakan '*' atau karakter non-breaking space
    const textContent =
        element.type === "password"
            ? " ".repeat(selectionStart)
            : element.value.substring(0, selectionStart);
    mirrorDiv.textContent = textContent || "\u00a0"; // Gunakan nbsp jika kosong

    // Buat span untuk menandai posisi caret
    const span = document.createElement("span");
    span.textContent = "\u00a0"; // Karakter dummy
    mirrorDiv.appendChild(span);

    // Hitung posisi span relatif terhadap input
    const elementRect = element.getBoundingClientRect();
    const spanRect = span.getBoundingClientRect();

    // Posisi relatif caret (top-left) di dalam input
    // Perlu penyesuaian berdasarkan scroll jika input bisa scroll (jarang untuk email/pass)
    const relativeX = spanRect.left - elementRect.left + element.scrollLeft;
    const relativeY = spanRect.top - elementRect.top + element.scrollTop;

    return { x: relativeX, y: relativeY };
}

// Dapatkan elemen canvas
const canvas = document.getElementById("logo-canvas");

// Hanya jalankan jika canvas ada
if (canvas) {
    const width = 500; // Lebar canvas
    const height = 400; // Tinggi canvas

    // 1. Setup Scene, Camera, Renderer
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        alpha: true, // Untuk latar belakang transparan
        antialias: true,
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(window.devicePixelRatio);
    camera.position.z = 5; // Posisi kamera mundur

    // 2. Add Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);
    const directionalLight = new THREE.DirectionalLight(0xffffff, 1.0);
    directionalLight.position.set(5, 10, 7.5);
    scene.add(directionalLight);

    let logoModel;
    let mouseX = 0,
        mouseY = 0;
    let targetRotationX = 0;
    let targetRotationY = 0;
    let currentRotationX = 0;
    let currentRotationY = 0;

    // --- Logic untuk Mengikuti Input Fokus ---
    const nameInput = document.getElementById("name"); // Untuk register
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const passwordConfirmationInput = document.getElementById(
        "password_confirmation"
    ); // Untuk register

    let isInputFocused = false;
    let focusedInputElement = null;

    function handleFocus(event) {
        isInputFocused = true;
        focusedInputElement = event.target;
    }

    function handleBlur() {
        isInputFocused = false;
        focusedInputElement = null;
        // Saat blur, target rotasi akan kembali ke posisi mouse
    }

    // Tambahkan listener ke semua input yang mungkin
    [nameInput, emailInput, passwordInput, passwordConfirmationInput].forEach(
        (input) => {
            if (input) {
                input.addEventListener("focus", handleFocus);
                input.addEventListener("blur", handleBlur);
            }
        }
    );
    // ----------------------------------------

    // 3. Load Model FBX
    const loader = new FBXLoader();
    loader.load(
        "/models/logo.fbx", // *** Pastikan path benar ***
        (object) => {
            logoModel = object;
            // *** Sesuaikan skala/posisi jika perlu ***
            logoModel.scale.set(0.01, 0.01, 0.01);
            logoModel.position.set(0, -0.5, 0);
            scene.add(logoModel);
            animate(); // Mulai animasi setelah model dimuat
        },
        undefined,
        (error) => {
            console.error("Error loading FBX model:", error);
        }
    );

    // 4. Mouse Listener (hanya aktif jika tidak ada input fokus)
    function updateMousePosition(event) {
        if (!isInputFocused) {
            // Hanya update jika tidak fokus
            mouseX = event.clientX / window.innerWidth - 0.5;
            mouseY = event.clientY / window.innerHeight - 0.5;
            // Atur target rotasi berdasarkan mouse (gunakan sensitivitas terakhir Anda)
            targetRotationY = mouseX * 2;
            targetRotationX = mouseY * 2;
        }
    }
    window.addEventListener("mousemove", updateMousePosition);

    // 5. Animation Loop
    function animate() {
        requestAnimationFrame(animate);

        // Tentukan target rotasi berdasarkan state fokus
        if (isInputFocused && focusedInputElement) {
            const rect = focusedInputElement.getBoundingClientRect();
            const inputCenterX = rect.left + rect.width / 2;
            const inputCenterY = rect.top + rect.height / 2;

            // Normalisasi posisi tengah input relatif ke window
            const normalizedInputX = inputCenterX / window.innerWidth - 0.5;
            const normalizedInputY = inputCenterY / window.innerHeight - 0.5;

            // Atur target rotasi untuk melihat ke arah input (gunakan sensitivitas terakhir Anda)
            targetRotationY = normalizedInputX * 2;
            targetRotationX = normalizedInputY * 2;
        } else {
            // Jika tidak fokus, targetRotationX/Y sudah diatur oleh mouse listener
        }

        if (logoModel) {
            // Interpolasi rotasi (gunakan kecepatan terakhir Anda)
            currentRotationY += (targetRotationY - currentRotationY) * 0.1;
            currentRotationX += (targetRotationX - currentRotationX) * 0.1;

            logoModel.rotation.y = currentRotationY;
            logoModel.rotation.x = currentRotationX;
        }

        renderer.render(scene, camera);
    }
} else {
    console.warn('Canvas element with ID "logo-canvas" not found.');
}
