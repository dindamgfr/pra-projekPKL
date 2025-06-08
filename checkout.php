<?php
session_start();
include 'koneksi.php';


if (!isset($_SESSION['users_id'])) {
    header("Location: login.php");
    exit;
} 

$users_id = $_SESSION['users_id'];
$keranjang = [];
$keranjang_ids_disimpan = [];
$harga_total = 0;
$error = '';

$nama_penerima = $_POST['nama_penerima'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$metode = $_POST['metode_pembayaran'] ?? '';
$username = '';
$pin = '';


// Handle tombol Buy Now
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buy_now"])) {
    $_SESSION["beli_langsung"] = [
        "produk_id" => $_POST["produk_id"],
        "jumlah" => $_POST["jumlah"]
    ];
}

// Ambil Data Produk
function ambil_data_produk($produk_id, $jumlah) {
    global $koneksi, $harga_total;

    $stmt = $koneksi->prepare("SELECT produk_id, nama, images, price_awal, discount_price FROM produk WHERE produk_id = ?");
    $stmt->bind_param("i", $produk_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();

    if ($produk) {
        $harga_diskon = $produk['price_awal'] - ($produk['discount_price'] / 100 * $produk['price_awal']);
        $subtotal = $harga_diskon * $jumlah;
        $harga_total += $subtotal;

        return [[
            'produk_id' => $produk['produk_id'],
            'nama' => $produk['nama'],
            'images' => $produk['images'],
            'jumlah' => $jumlah,
            'harga' => $harga_diskon,
            'subtotal' => $subtotal
        ]];
    }
    return [];
}

// Ambil Data dari Keranjang
function ambil_data_keranjang($keranjang_ids, $users_id) {
    global $koneksi, $harga_total, $keranjang_ids_disimpan;

    $keranjang = [];
    if (count($keranjang_ids) > 0) {
        $in = str_repeat('?,', count($keranjang_ids) - 1) . '?';
        $types = str_repeat('i', count($keranjang_ids)) . 'i';
        $params = array_merge($keranjang_ids, [$users_id]);

        $sql = "SELECT k.keranjang_id, k.jumlah_produk, p.produk_id, p.nama, p.images, 
                       p.price_awal, p.discount_price, 
                       (p.price_awal - (p.discount_price / 100 * p.price_awal)) AS harga_setelah_diskon
                FROM keranjang k 
                JOIN produk p ON k.produk_id = p.produk_id 
                WHERE k.keranjang_id IN ($in) AND k.users_id = ?";

        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $subtotal = $row['harga_setelah_diskon'] * $row['jumlah_produk'];
            $harga_total += $subtotal;

            $keranjang[] = [
                'keranjang_id' => $row['keranjang_id'],
                'produk_id' => $row['produk_id'],
                'nama' => $row['nama'],
                'images' => $row['images'],
                'jumlah' => $row['jumlah_produk'],
                'harga' => $row['harga_setelah_diskon'],
                'subtotal' => $subtotal
            ];
            $keranjang_ids_disimpan[] = $row['keranjang_id'];
        }
    }
    return $keranjang;
}

// Ambil data saat halaman dimuat (GET atau POST)
/* =======================
   1. Ambil data keranjang
   =======================*/
if (isset($_GET['langsung']) && isset($_SESSION["beli_langsung"])) {
    $keranjang = ambil_data_produk($_SESSION["beli_langsung"]["produk_id"],
                                   $_SESSION["beli_langsung"]["jumlah"]);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pilih"])) {
    $keranjang = ambil_data_keranjang(array_keys($_POST["pilih"]), $users_id);
}

/* =========================================================
   2. BARU SEKARANG hitung ringkasan biaya (di sini!)
   =========================================================*/
$totalBeforeOngkir = $harga_total;          // subtotal produk
$ongkir            = intval($_POST['ongkir'] ?? 0);
$grandTotal        = $totalBeforeOngkir + $ongkir;


// Proses saat checkout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_checkout"])) {
    if (isset($_SESSION["beli_langsung"])) {
        $keranjang = ambil_data_produk($_SESSION["beli_langsung"]["produk_id"], $_SESSION["beli_langsung"]["jumlah"]);
        $dari_keranjang = false;
        $keranjang_ids = []; // Kosong karena bukan dari keranjang
        unset($_SESSION["beli_langsung"]);
    } elseif (isset($_POST["keranjang_ids"])) {
        $keranjang_ids = array_map('intval', $_POST["keranjang_ids"]);
        $keranjang = ambil_data_keranjang($keranjang_ids, $users_id);
        $dari_keranjang = true;
    }

    // Validasi form
    if (empty($nama_penerima) || empty($alamat) || empty($no_hp)) {
        $error = "Nama penerima, alamat, dan nomor HP wajib diisi.";
    } elseif (empty($metode)) {
        $error = "Silakan pilih metode pembayaran.";
    } else {
        if ($metode === 'shopeepay') {
            $username = $_POST['shopeepay_username'] ?? '';
            $pin = $_POST['shopeepay_pin'] ?? '';
            if (empty($username) || empty($pin)) {
                $error = "Username dan PIN ShopeePay wajib diisi.";
            }
        } elseif ($metode === 'gopay') {
            $username = $_POST['gopay_username'] ?? '';
            $pin = $_POST['gopay_pin'] ?? '';
            if (empty($username) || empty($pin)) {
                $error = "Username dan PIN GoPay wajib diisi.";
            }
        } else {
            $error = "Metode pembayaran tidak valid.";
        }

        $ongkir = intval($_POST['ongkir'] ?? 0);
        $grand  = $harga_total + $ongkir;   // total fix
        
        if (empty($error)) {
            $_SESSION['checkout'] = [
                'produk'            => $keranjang,
                'alamat'            => $alamat,
                'nama_penerima'     => $nama_penerima,
                'no_hp'             => $no_hp,
                'username'          => $username,
                'pin'               => $pin,
                'ongkir'            => $ongkir,
                'total_bayar'       => $grand,      // ← kirim siap pakai
                'metode_pembayaran' => $metode,
                'dari_keranjang'    => $dari_keranjang,
                'keranjang_ids'     => $keranjang_ids
            ];
            header("Location: payment_process.php");
            exit();
        }
    }
}

?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff0f6;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
            color: #B8336A;
            font-family: 'Playfair Display', serif;
        }
        .card-checkout {
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .produk-item {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
        }
        .produk-item img {
            width: 120px;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
        }
        .produk-detail {
            flex-grow: 1;
        }
        .produk-detail strong {
            font-size: 1.2rem;
            color: #5D1A6D;
        }
        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 10px;
            padding: 10px;
        }
        .payment-method {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .payment-method label {
            text-align: center;
            cursor: pointer;
        }
        .payment-method input {
            display: none;
        }
        .payment-method img {
            width: 100px;
            height: 100px;
            border-radius: 15px;
            transition: 0.3s ease;
            border: 2px solid transparent;
        }
        .payment-method input:checked + img {
            border: 2px solid #ff8db7;
            transform: scale(1.05);
        }
        .btn-pay {
            background: linear-gradient(90deg, #ff8db7, #fbb1ff);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            font-size: 1.2rem;
            margin-top: 25px;
            transition: 0.3s ease;
        }
        .btn-pay:hover {
            background: linear-gradient(90deg, #fbb1ff, #ff8db7);
        }
        .text-danger {
            color: red;
        }

        /* css gopay */
        .gopay-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        }

        .gopay {
        width: 100%;
        max-width: 500px;
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .form-title-gopay {
        text-align: center;
        font-size: 28px;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 30px;
        }

        .total-harga-gopay {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #2980b9;
        font-family: 'Roboto', sans-serif;
        }

        .form-control {
        width: 100%;
        border-radius: 10px;
        padding: 12px;
        border: 1.5px solid #a3d0ff;
        margin-top: 5px;
        }

        .btn-submit-gopay {
        background: linear-gradient(to right, #6dd5fa, #2980b9);
        color: white;
        padding: 12px;
        border-radius: 30px;
        font-weight: bold;
        border: none;
        width: 100%;
        transition: 0.3s;
        margin-top: 20px;
        }

        /* css shopeepay */

        .shopeepay-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }  

        .shopeepay-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        }

        .shopeepay {
        width: 100%;
        max-width: 500px;
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .form-title-shopeepay {
        font-size: 28px;
        font-weight: bold;
        color: #a04fc0;
        text-align: center;
        margin-bottom: 30px;
        }

        .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 1.5px solid #dcb4f7;
        }

        .btn-submit {
        background: linear-gradient(to right, #f8b6cc, #e3a0f6);
        color: white;
        padding: 12px;
        border-radius: 30px;
        font-weight: bold;
        border: none;
        width: 100%;
        transition: 0.3s;
        margin-top: 20px;
        }

        .total-harga-shopeepay {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #df67df;
        font-family: 'Roboto', sans-serif;
        }

    </style>
</head>
<body>

    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="checkout-header">Checkout</div>

        <?php if (!empty($error)): ?>
            <div class="text-danger mb-3 text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

    <form method="POST" action="checkout.php">
        <div class="card-checkout">
            <h4 class="mb-3">Produk yang Dibeli</h4>
                <?php if (empty($keranjang)): ?>
                    <p class="text-center text-muted">Tidak ada produk yang dipilih.</p>
                <?php else: ?>
                    <?php foreach ($keranjang as $item): ?>
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <img src="gambar/<?= htmlspecialchars($item['images']) ?>" width="100" style="margin-right: 15px;">
                            
                            <div class="produk-checkout produk-detail">
                                <strong><?= htmlspecialchars($item['nama']) ?></strong><br>
                                Harga Setelah Diskon: Rp<?= number_format($item['harga'], 0, ',', '.') ?><br>
                                Jumlah: <?= $item['jumlah'] ?><br>
                                Subtotal: Rp<?= number_format($item['subtotal'], 0, ',', '.') ?><br>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>

                    <!-- Form lanjutan pembayaran di sini -->
                <?php endif; ?>
        </div>

                <!-- --- WILAYAH PENGIRIMAN & RINGKASAN BIAYA --- -->
                <div class="card-checkout">
                <h4 class="mb-3">Wilayah Pengiriman</h4>

                <div class="row mb-3">
                    <div class="col-5">Wilayah Pengiriman</div>
                    <div class="col-1 text-center">:</div>
                    <div class="col-6">
                    <select id="region" class="text-center form-select" name="region"
                            onchange="updateOngkir()" required>
                        <option value="">-- Pilih Wilayah --</option>
                        <option value="jawa">Jawa</option>
                        <option value="sumatra">Sumatra</option>
                        <option value="sulawesi">Sulawesi</option>
                        <option value="kalimantan">Kalimantan</option>
                        <option value="bali">Bali</option>
                        <option value="papua">Papua</option>
                    </select>
                    </div>
                </div>

                <!-- Ringkasan biaya -->
                <div class="row">
                    <div class="col-5">SubTotal</div>
                    <div class="col-1 text-center">:</div>
                    <div class="col-6 text-end">Rp<span id="preOngkir">
                        <?= number_format($totalBeforeOngkir,0,',','.') ?>
                    </span></div>
                </div>
                <div class="row">
                    <div class="col-5">Ongkir</div>
                    <div class="col-1 text-center">:</div>
                    <div class="col-6 text-end">Rp<span id="ongkirDisplay">0</span></div>
                </div>
                <div class="row fw-bold">
                    <div class="col-5">Grand Total</div>
                    <div class="col-1 text-center">:</div>
                    <div class="col-6 text-end fw-bold">Rp<span id="grandTotal">
                        <?= number_format($grandTotal,0,',','.') ?>
                    </span></div>
                </div>
                </div>

                <!-- kirim ongkir ke server -->
                <input type="hidden" id="ongkirInput" name="ongkir" value="0">
                
        
        <?php if (!empty($keranjang_ids_disimpan)): ?>
            <?php foreach ($keranjang_ids_disimpan as $kid): ?>
                <input type="hidden" name="keranjang_ids[]" value="<?= $kid ?>">
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="card-checkout">
            <h4 class="mb-3">Informasi Pengiriman</h4>
            <div class="mb-3">
                <input type="text" name="nama_penerima" class="form-control" placeholder="Nama penerima" required value="<?= htmlspecialchars($nama_penerima) ?>">
            </div>
            <div class="mb-3">
                <input type="text" name="alamat" class="form-control" placeholder="Alamat lengkap" required value="<?= htmlspecialchars($alamat) ?>">
            </div>
            <div class="mb-3">
                <input type="text" name="no_hp" class="form-control" placeholder="Nomor HP" required value="<?= htmlspecialchars($no_hp) ?>">
            </div>
        </div>


        <!-- METODE PEMBAYARAN -->
        <div class="card-checkout">
            <h4 class="mb-3">Metode Pembayaran</h4>
            <div class="payment-method">
                <label>
                    <input type="radio" name="metode_pembayaran" value="shopeepay" onclick="showPaymentForm('shopeepay')" required >
                    <img src="gambar/shopee.png" alt="ShopeePay"><br>
                    ShopeePay
                </label>
                <label>
                    <input type="radio" name="metode_pembayaran" value="gopay" onclick="showPaymentForm('gopay')" required>
                    <img src="gambar/gopay.png" alt="GoPay"><br>
                    GoPay
                </label>
            </div>
        </div>

        <!-- FORM GOPAY -->
        <div id="form-gopay" style="display: none;" class=" payment-form">
        <div class="gopay-container">
            <div class="gopay">
            <h2 class="form-title-gopay">Bayar dengan GoPay</h2>
            <div class="total-harga-gopay">
                Total Pembayaran: Rp<span id="totalGopay">
                    <?= number_format($grandTotal,0,',','.') ?>
                </span>
            </div>
            
            <div class="mb-3">
                <label for="username" class="form-label">Username GoPay</label><br>
                <input type="text" class="form-control" id="username" name="gopay_username" required>
            </div>
            <div class="mb-3">
                <label for="pin" class="form-label">PIN</label><br>
                <input type="password" class="form-control" id="pin" name="gopay_pin" maxlength="6" required>
            </div>
            </div>
        </div>
        </div>


        <!-- FORM SHOPEEPAY -->
        <div id="form-shopeepay" style="display: none;" class="payment-form">
            <div class="shopeepay-container">
                <div class="shopeepay">
                    <h2 class="form-title-shopeepay">Bayar dengan ShopeePay</h2>
                    <div class="total-harga-shopeepay">
                        Total Pembayaran: Rp<span id="totalShopee">
                            <?= number_format($grandTotal,0,',','.') ?>
                        </span>
                    </div>
                    
                        <div class="mb-3">
                            <label for="shopeepay_username" class="form-label">Username Shopee</label>
                            <input type="text" class="form-control" id="shopeepay_username" name="shopeepay_username" required>
                        </div>
                        <div class="mb-3">
                            <label for="shopeepay_pin" class="form-label">PIN</label>
                            <input type="password" class="form-control" id="shopeepay_pin" name="shopeepay_pin" maxlength="6" required>
                        </div>
                </div>
            </div>
        </div>

    <!-- Tambahan submit button -->
    <div class="text-center mt-4 mb-5">
        <button type="submit" name="submit_checkout" class="btn-pay">Lanjut ke Pembayaran</button>
    </div>


    </form>
    </div>

    <!-- js untuk memilih metode pembayaran -->
    <script>
        function showPaymentForm(metode) {
            // Sembunyikan form
            document.getElementById('form-gopay').style.display = metode === 'gopay' ? 'block' : 'none';
            document.getElementById('form-shopeepay').style.display = metode === 'shopeepay' ? 'block' : 'none';

            // Nonaktifkan semua required field dulu
            document.getElementById('username').required = false;
            document.getElementById('pin').required = false;
            document.getElementById('shopeepay_username').required = false;
            document.getElementById('shopeepay_pin').required = false;

            // Aktifkan required sesuai metode
            if (metode === 'gopay') {
                document.getElementById('username').required = true;
                document.getElementById('pin').required = true;
            } else if (metode === 'shopeepay') {
                document.getElementById('shopeepay_username').required = true;
                document.getElementById('shopeepay_pin').required = true;
            }
        }

        // Jalankan saat halaman dimuat, untuk restore pilihan sebelumnya
        document.addEventListener("DOMContentLoaded", function () {
            const selectedMethod = "<?= $metode ?>";
            if (selectedMethod === "gopay") {
                document.querySelector('input[name="metode_pembayaran"][value="gopay"]').checked = true;
                showPaymentForm("gopay");
            } else if (selectedMethod === "shopeepay") {
                document.querySelector('input[name="metode_pembayaran"][value="shopeepay"]').checked = true;
                showPaymentForm("shopeepay");
            }
        });
    </script>

    <!-- js untuk ongkir -->
    <script>
    function updateOngkir() {
        const region = document.getElementById("region").value;
        const ongkirDisplay = document.getElementById("ongkirDisplay");
        const ongkirInput = document.getElementById("ongkirInput");
        const preOngkir = parseInt(document.getElementById("preOngkir").innerText.replace(/\./g, '')) || 0;
        let ongkir = 0;

        switch (region) {
            case "jawa": ongkir = 10000; break;
            case "sumatra": ongkir = 15000; break;
            case "sulawesi": ongkir = 20000; break;
            case "kalimantan": ongkir = 22000; break;
            case "bali": ongkir = 18000; break;
            case "papua": ongkir = 30000; break;
        }

        ongkirDisplay.innerText = ongkir.toLocaleString('id-ID');

        const grandTotal = preOngkir + ongkir;
        document.getElementById("grandTotal").innerText = grandTotal.toLocaleString('id-ID');
        ongkirInput.value = ongkir;

        /* ---- NEW ----  */
        document.getElementById("totalGopay").innerText   = grandTotal.toLocaleString('id-ID');
        document.getElementById("totalShopee").innerText  = grandTotal.toLocaleString('id-ID');
    }
    document.addEventListener("DOMContentLoaded", updateOngkir);

    // Tangani submit form
    document.querySelector("form").addEventListener("submit", function(e) {
        const region = document.getElementById("region").value;
        if (!region) {
            e.preventDefault();
            alert("Silakan pilih wilayah pengiriman terlebih dahulu.");
        } else {
            updateOngkir(); // Pastikan ongkir terupdate sebelum submit
        }
    });
    </script>


    <?php include 'footer.html'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle"></script>
  
</body>
</html>