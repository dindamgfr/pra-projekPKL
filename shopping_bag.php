<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['users_id'])) {
    header("Location: login.php");
    exit;
}

$users_id = $_SESSION['users_id'];

// Hapus produk dari keranjang
if (isset($_GET['hapus'])) {
    $hapus_id = intval($_GET['hapus']);
    $stmt = $koneksi->prepare("DELETE FROM keranjang WHERE keranjang_id = ? AND users_id = ?");
    $stmt->bind_param('ii', $hapus_id, $users_id);
    $stmt->execute();
    header("Location: shopping_bag.php");
    exit;
}

// Ambil dari data di keranjang
$stmt = $koneksi->prepare("SELECT k.keranjang_id, k.jumlah_produk, p.nama, p.images AS foto, p.price_awal, p.discount_price AS harga, 
((p.price_awal - (p.discount_price / 100 * p.price_awal )) * k.jumlah_produk) AS subtotal,
(p.price_awal - (p.discount_price / 100 * p.price_awal )) AS harga_setelah_diskon
    FROM keranjang k
    JOIN produk p ON k.produk_id = p.produk_id
    WHERE k.users_id = ?");

$stmt->bind_param('i', $users_id);
$stmt->execute();
$result = $stmt->get_result();
$keranjang = $result->fetch_all(MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produk_id = $_POST['produk_id'];
    $jumlah = $_POST['jumlah'];
    $users_id = $_SESSION['users_id']; // Pastikan user login

    if ($jumlah > 0) {
        // Ambil harga dan diskon
        $produk_query = mysqli_query($koneksi, "SELECT price_awal, discount_price FROM produk WHERE produk_id = '$produk_id'");
        $produk = mysqli_fetch_assoc($produk_query);

        $harga_awal = $produk['price_awal'];
        $diskon = $produk['discount_price'];
        $harga_setelah_diskon = $harga_awal - ($harga_awal * $diskon / 100);

        // Cek apakah sudah ada produk ini di keranjang
        $cek = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE users_id='$users_id' AND produk_id='$produk_id'");

        if (mysqli_num_rows($cek) > 0) {
            // Produk sudah ada, update jumlah dan subtotal
            $row = mysqli_fetch_assoc($cek);
            $jumlah_lama = $row['jumlah_produk'];
            $jumlah_baru = $jumlah_lama + $jumlah;
            $subtotal_baru = $harga_setelah_diskon * $jumlah_baru;

            mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk = $jumlah_baru, subtotal = $subtotal_baru WHERE users_id='$users_id' AND produk_id='$produk_id'");
        } else {
            // Produk belum ada, insert baru
            $subtotal_baru = $harga_setelah_diskon * $jumlah;

            mysqli_query($koneksi, "INSERT INTO keranjang (users_id, produk_id, jumlah_produk, subtotal) VALUES ('$users_id', '$produk_id', '$jumlah', '$subtotal_baru')");
        }

        header('Location: shopping_bag.php');
        exit;
    }
}

// Proses update jumlah jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_update_jumlah'])) {
    $keranjang_id = intval($_POST['keranjang_id']);
    $jumlah_baru = max(1, intval($_POST['jumlah_baru']));

    $stmt = $koneksi->prepare("UPDATE keranjang SET jumlah_produk = ? WHERE keranjang_id = ? AND users_id = ?");
    $stmt->bind_param('iii', $jumlah_baru, $keranjang_id, $users_id);
    $stmt->execute();

    echo "Sukses";
    exit; // Penting agar tidak lanjut ke HTML
}



?>




<!DOCTYPE html>
<html lang="id">
     <meta charset="UTF-8">
    <title>Shopping Bag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<head>
        <style>
        body {
            background-color: #fff0f6;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .bag-header {
            text-align: center;
            font-size: 2.5rem;
            color: #B8336A;
            margin-bottom: 30px;
            font-family: 'Playfair Display', serif;
        }

        .card-bag {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .produk-item {
            display: flex;
            align-items: center;
            gap: 20px;
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

        .jumlah-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .jumlah-box button {
            background-color: #ffc0cb;
            border: none;
            padding: 5px 12px;
            font-size: 1rem;
            border-radius: 5px;
        }

        .jumlah-box input {
            width: 50px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .hapus-btn {
            background-color: transparent;
            border: none;
            color: crimson;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .total-harga {
            font-size: 1.3rem;
            font-weight: bold;
            text-align: right;
            color: #333;
        }

        .btn-checkout {
            width: auto; /* Agar lebar tombol mengikuti ukuran konten */
            padding: 12px;
            font-size: 1.2rem;
            background: linear-gradient(90deg, #ff8db7, #fbb1ff);
            border: none;
            border-radius: 10px;
            color: white;
            transition: 0.3s;
            text-decoration: none;
            text-align: center; /* Membuat teks di tengah */
            margin-left: auto; /* Menggeser tombol ke kanan */
        }
        .btn-checkout:hover {
            background: linear-gradient(90deg, #fbb1ff, #ff8db7);
        }
    </style>
</head>
<body>
<?php include 'nav.php'; ?>
<div class="container">
    <div class="bag-header">Shopping Bag</div>
<form action="checkout.php" method="post">
    <?php if (empty($keranjang)): ?>
        <p class="text-center text-muted">Keranjang kamu kosong.</p>
    <?php else: ?>
        <?php foreach ($keranjang as $item): ?>
            <div class="card-bag">
                <div class="produk-item">
                    <img src="gambar/<?= htmlspecialchars($item['foto']) ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                    <div class="produk-detail">
                        <strong><?= htmlspecialchars($item['nama']) ?></strong><br>

                        <?php if (isset($item['price_awal']) && $item['price_awal'] > $item['harga']): ?>
                            <small>Harga Awal: <del>Rp <?= number_format($item['price_awal'], 0, ',', '.') ?></del></small><br>
                            <small>Harga Seletah Diskon: Rp <?= number_format($item['harga_setelah_diskon'], 0, ',', '.') ?></small><br>
                        <?php endif; ?>

                        <span style="color: #d9534f; font-weight: bold;">
                            <span >Diskon: <?= number_format($item['harga'], 0, ',', '.'); ?>%</span>
                        </span><br>

                        <div class="jumlah-box">
                            <button type="button" onclick="ubahJumlah(<?= $item['keranjang_id'] ?>, -1)">-</button>

                            <input type="text"name="jumlah[<?= $item['keranjang_id'] ?>]" id="jumlah_produk<?= $item['keranjang_id'] ?>"
                                value="<?= $item['jumlah_produk'] ?>" min="1"data-harga="<?= $item['harga_setelah_diskon'] ?>"
                                class="jumlah-input" data-id="<?= $item['keranjang_id'] ?>" oninput="hitungSubtotalDanTotal()" readonly >

                            <button type="button" onclick="ubahJumlah(<?= $item['keranjang_id'] ?>, 1)">+</button>
                        </div>


                    </div>
                    <div class="text-end">
                        Subtotal:<br>
                        <span class="subtotal" id="subtotal_<?= $item['keranjang_id'] ?>">
                            Rp<?= number_format($item['subtotal'], 0, ',', '.') ?>
                        </span><br><br>
                        <a href="?hapus=<?= $item['keranjang_id'] ?>" class="hapus-btn" onclick="return confirm('Hapus produk ini?')">Hapus</a><br>
                        <input type="checkbox" name="pilih[<?= $item['keranjang_id'] ?>]" value="1" class="checkbox-produk" onchange="updateTotal()"> Pilih Produk
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="card-bag">
            <div class="total-harga">Total: <span id="totalHarga">Rp0</span></div>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" name="from_cart" class="btn-checkout w-100">Lanjut ke Checkout</button>
        </div>
    <?php endif; ?>
</form>



</div>

<script>
function validasiPilihProduk() {
    const checkbox = document.querySelectorAll('.checkbox-produk:checked');
    if (checkbox.length === 0) {
        alert('Pilih minimal satu produk untuk checkout!');
        return false;
    }
    return true;
}
</script>


<script>
document.querySelector("form").addEventListener("change", function() {
    const jumlah = document.querySelector("input[name='angka']").value;
    document.querySelectorAll("input[name='jumlah']").forEach(function(input) {
        input.value = jumlah;
    });
});
</script>

<script>
function ubahJumlah(id, delta) {
    const input = document.getElementById('jumlah_produk' + id);
    let jumlah = parseInt(input.value);
    jumlah = isNaN(jumlah) ? 1 : jumlah + delta;
    if (jumlah < 1) jumlah = 1;
    input.value = jumlah;

    hitungSubtotalDanTotal();

    // Kirim update ke PHP dan reload jika sukses
    fetch('shopping_bag.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `ajax_update_jumlah=1&keranjang_id=${id}&jumlah_baru=${jumlah}`
    }).then(response => response.text())
      .then(data => {
          console.log("Jumlah diupdate:", data);
          location.reload();
      });
}



function hitungSubtotalDanTotal() {
    let total = 0;

    document.querySelectorAll('.jumlah-input').forEach(input => {
        const id = input.dataset.id;
        const harga = parseInt(input.dataset.harga);
        const jumlah = parseInt(input.value);
        const subtotal = harga * jumlah;

        // Update tampilan subtotal
        const subtotalElement = document.getElementById('subtotal_' + id);
        if (subtotalElement) {
            subtotalElement.textContent = 'Rp' + subtotal.toLocaleString('id-ID');
        }

        // Hitung total hanya jika produk dicentang
        const checkbox = document.querySelector(`input[name="pilih[${id}]"]`);
        if (checkbox && checkbox.checked) {
            total += subtotal;
        }
    });

    document.getElementById('totalHarga').textContent = 'Rp' + total.toLocaleString('id-ID');
}

// Trigger saat checkbox berubah
document.querySelectorAll('.checkbox-produk').forEach(cb => {
    cb.addEventListener('change', hitungSubtotalDanTotal);
});

// Trigger saat jumlah manual diinput
document.querySelectorAll('.jumlah-input').forEach(input => {
    input.addEventListener('input', hitungSubtotalDanTotal);
});
</script>

<?php include 'footer.html'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
