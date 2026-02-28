<style>
    @page {
        size: A4;
        margin: 8mm 6mm 8mm 8mm;
    }

    body {
        margin: 0;
        padding: 0;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 2mm 2mm;
    }

    td {

        width: 36mm;
        height: 24mm;

        border: 1px solid black;

        text-align: center;

        vertical-align: middle;

        font-size: 10px;

    }
</style>


<?php

$total = 40;

$isi = count($data) + $kosong;

$sisa = $total - $isi;

$semua = [];


/* kosong awal */
for ($i = 0; $i < $kosong; $i++) {
    $semua[] = "";
}

/* isi barang */
foreach ($data as $d) {
    $semua[] = $d;
}

/* kosong akhir */
for ($i = 0; $i < $sisa; $i++) {
    $semua[] = "";
}

?>



<table>

    <?php for ($i = 0; $i < 40; $i += 5) { ?>

    <tr>

        <?php

    $baris = $i / 5;

    /* kalau baris genap → kiri ke kanan */
    if ($baris % 2 == 0) {

        for ($j = 0; $j < 5; $j++) {

            $index = $i + $j;
?>

        <td>

            <?php            if ($semua[$index] != "") { ?>

            <b><?php                echo $semua[$index]->nama_barang; ?></b>

            <br><br>

            Rp <?php                echo $semua[$index]->harga; ?>

            <?php            } ?>

        </td>

        <?php        }

        /* kalau baris ganjil → kanan ke kiri */

    } else {

        for ($j = 4; $j >= 0; $j--) {

            $index = $i + $j;
?>

        <td>

            <?php            if ($semua[$index] != "") { ?>

            <b><?php                echo $semua[$index]->nama_barang; ?></b>

            <br><br>

            Rp <?php                echo $semua[$index]->harga; ?>

            <?php            } ?>

        </td>

        <?php        }

    }

?>

    </tr>

    <?php } ?>

</table>