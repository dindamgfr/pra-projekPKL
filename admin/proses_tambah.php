<?php
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "DEBUG: POST request diterima<br>";
    print_r($_POST);
    print_r($_FILES);
}

if (isset($_POST['simpan'])) {
    echo "DEBUG: Tombol simpan terdeteksi<br>";

// function kie fungsine nggo merubah nama gambar asli ne ko dadi nama sembarang si bakal disimpen nang folder gambar  
function generateRandomString($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; //ini untuk huruf baru yang akan dipakay ya mill
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){
        $randomString .= $characters[rand(0, $charactersLength -1)];
    }
    return $randomString;
}

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $kategori_id = $_POST['kategori_id'];
    $price_awal = $_POST['price_awal'];
    $discount_price = $_POST['discount_price'];
    $stok = $_POST['stok'];
    $description = $_POST['description'];


    $folder = "../gambar/"; //tempat menyimpan gambar
    $nama_file =  basename($_FILES["images"]["name"]); 
    $target_file = $folder . $nama_file; // kie kaya nggo mindahna file gambar e ko tok
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // nek kie aku kurang paham nonton bae sng nng tutor sing durasi 2 jam nnag menit 30-40 an nek ora salah
    $image_size = $_FILES["images"]["size"]; // nek kie nggo ngukur ukuran foto ne misal kegeden ora bakal bisa nang ngisor ana penjelasan e
    $random_name = generateRandomString(20); // nek kie nggo manggil function e
    $baru = $random_name . "." . $imageFileType; // nek kie kaya nggo mindahna tok ben gampang nek kurang jelas tonton video tutor e


    if($nama_file!=''){
        if($image_size > 100000){ // kie nggo ngukur ben ukuran foto ora ngelewati batas sng ws ditentukna
            echo "ukuran gambar terlalu besar!";
            exit;
            ?>
            <div class="alert alert-warning mt-3" role="alert">
                Foto tidak boleh lebih dari 100000 kb
            </div>
            <?php
        }else{
            if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif'){ // nek kie nggo tipe file e selain sng ws disaranna ora bisa diinput
                ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Foto wajib bertipe jpg, png, atau gif
                </div>
                <?php
            }else{
                move_uploaded_file($_FILES["images"]["tmp_name"], $folder . $baru); // kie sing nggo upload e
            }
        }
        
        // //query insert ke dalam tabel produk
        $query = mysqli_query($koneksi, "INSERT INTO produk (kategori_id, nama, price_awal, discount_price, stok, description, images) VALUES 
        ('$kategori_id', '$nama', '$price_awal', '$discount_price', '$stok', '$description', '$baru')");
            

            if ($query) {
                echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href = 'dataproduk.php';</script>";
            } else {
                echo "Query Error: " . mysqli_error($koneksi);
            }            
    }
}
}
?>