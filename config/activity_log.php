<?php

/**
 * Fungsi untuk mencatat aktivitas pengguna
 * ke dalam tabel log_aktivitas.
 *
 * @param mysqli $conn
 * @param string $aktivitas
 * @param string $deskripsi
 * @return bool
 */
function logAktivitas($conn, $aktivitas, $deskripsi)
{
    $sql = "INSERT INTO log_aktivitas (aktivitas, deskripsi)
            VALUES (?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $aktivitas,
        $deskripsi
    );

    $berhasil = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $berhasil;
}