<?php

namespace App\Policies;

use App\User;

class PeminjamanPolicy
{
    /**
     * Menentukan apakah user dapat melihat semua data peminjaman.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('lihat peminjaman');
    }

    /**
     * Menentukan apakah user dapat melihat detail peminjaman.
     */
    public function view(User $user): bool
    {
        return $user->can('lihat peminjaman');
    }

    /**
     * Menentukan apakah user dapat membuat peminjaman.
     */
    public function create(User $user): bool
    {
        return $user->can('tambah peminjaman');
    }

    /**
     * Menentukan apakah user dapat mengubah data peminjaman.
     */
    public function update(User $user): bool
    {
        return $user->can('ubah peminjaman');
    }

    /**
     * Menentukan apakah user dapat menghapus peminjaman.
     */
    public function delete(User $user): bool
    {
        return $user->can('hapus peminjaman');
    }

    /**
     * Menentukan apakah user dapat mengembalikan barang yang dipinjam.
     */
    public function return(User $user): bool
    {
        return $user->can('kembalikan peminjaman');
    }

    /**
     * Menentukan apakah user dapat memulihkan data peminjaman (opsional).
     */
    public function restore(User $user): bool {}

    /**
     * Menentukan apakah user dapat menghapus permanen data peminjaman (opsional).
     */
    public function forceDelete(User $user): bool {}
}
