<style>
    @page {
        size: A4;
        margin: 2mm;
    }

    body {
        margin: 0;
        padding: 0;
    }

    table {
        width: auto;
        border-collapse: separate;
        border-spacing: 3mm 2mm;
    }

    td {
        width: 38mm;
        height: 18mm;
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
        padding: 0;
    }
</style>

<?php

$total = 40;

// jumlah isi + posisi kosong awal
$isi = count($data) + $kosong;

// pastikan tidak negatif
$sisa = max(0, $total - $isi);

$semua = [];

/* kosong awal (posisi X,Y) */
for ($i = 0; $i < $kosong; $i++) {
    $semua[] = null;
}

/* isi barang */
foreach ($data as $d) {
    $semua[] = $d;
}

/* kosong akhir */
for ($i = 0; $i < $sisa; $i++) {
    $semua[] = null;
}

/* pastikan total 40 kotak */
$semua = array_pad($semua, $total, null);

?>

<table>

    <?php for ($i = 0; $i < $total; $i += 5) { ?>

    <tr>

        <?php    for ($j = 0; $j < 5; $j++) {

        $index = $i + $j;
        ?>

        <td>

            <?php        if (!empty($semua[$index])) { ?>

            <!-- BARCODE -->
            <img src="data:image/png;base64,<?= $semua[$index]->barcode ?>" width="120">
            <br>

            <b><?= $semua[$index]->nama ?? '-' ?></b>
            <br>

            Rp <?= number_format($semua[$index]->harga ?? 0, 0, ',', '.') ?>
            <br>

            <?= $semua[$index]->kode ?? '-' ?>

            <?php        } ?>

        </td>

        <?php    } ?>

    </tr>

    <?php } ?>

</table>