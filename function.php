<?php

    //membuat koneksi
    $conn=mysqli_connect("localhost", "root", "", "phpdatabse");

    if(!$conn){
        die('Koneksi Error : '.mysqli_connect_errno()
        .' - '.mysqli_connect_error());
    }

    //ambil data dari tabel mahasiswa/query data mahasiswa
    $result=mysqli_query($conn,"SELECT * FROM mahasiswa");

    //function query akan menerima isi parameter dari string query yang ada pada index2.php (line 3)
    function query($query_kedua){
        //dikarena $conn diluar function query maka dibutuhkan scope global $$conn

        global $conn;
        $result = mysqli_query($conn, $query_kedua);

        //wadah kosong untuk menampung isi array pada saat looping line 16

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function tambah ($data) {
        global $conn;

        $Nama = $_POST["Nama"];
        $Nim = $_POST["Nim"];
        $Email = $_POST["Email"];
        $Jurusan = $_POST["Jurusan"];
        $Gambar = $_POST["Gambar"];

        $query = "  INSERT INTO mahasiswa
                    VALUES
                    ('','$Nama','$Nim','$Email','$Jurusan','$Gambar')";
        
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
        
    }

    function hapus ($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM mahasiswa WHERE id =$id");
        return mysqli_affected_rows($conn);
    }

    function edit ($data){
        global $conn;

        $id = $data["id"];
        
        $Nama = htmlspecialchars($data["Nama"]);
        $Nim = htmlspecialchars($data["Nim"]);
        $Email = htmlspecialchars($data["Email"]);
        $Jurusan = htmlspecialchars($data["Jurusan"]);
        $Gambar = htmlspecialchars($data["Gambar"]);

        $query = " UPDATE mahasiswa SET
                    Nama = '$Nama',
                    Nim = '$Nim',
                    Email = '$Email',
                    Jurusan = '$Jurusan',
                    Gambar = '$Gambar'
                    WHERE id = $id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function cari($keyword){

        $sql = "SELECT * FROM mahasiswa
                WHERE
                Nama LIKE '%$keyword%' OR
                Nim LIKE '%$keyword%' OR
                Email LIKE '%$keyword%' OR
                Jurusan LIKE '%$keyword%' 
                ";

                return query($sql);
    }
?>