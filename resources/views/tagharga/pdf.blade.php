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
    for ($j = 0; $j < 5; $j++) {

        $index = $i + $j;
?>

        <td>

            <?php        if ($semua[$index] != "") { ?>

            <b><?php            echo $semua[$index]->nama_barang; ?></b>
            <br><br>
            Rp <?php            echo number_format($semua[$index]->harga, 0, ',', '.'); ?>

            <?php        } ?>

        </td>

        <?php    } ?>

    </tr>

    <?php } ?>

</table>