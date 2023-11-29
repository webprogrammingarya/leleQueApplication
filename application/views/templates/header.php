<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LeleQue</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/'); ?>/images/logos/favicon.png" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>/css/styles.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>/css/stylesPersonal.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="56a08b6a-5ee2-40e3-a28e-29c1a6930c4b";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script> -->
    <style>
        #card-responsive {
            display: none;
        }
        .card-responsive {
            display: none;
        }
        #btnTambah-responsive-pb {
            display: none;
        }
        #btnUtangPelanggan {
            display: none;
        }
        #btnUtangSaya {
            display: none;
        }
        @media only screen and (max-width: 720px) {
            #table-responsive {
                display: none;
            }
            .table-responsive {
                display: none;
            }
            #card-responsive {
                display: block;
            }
            .card-responsive {
                display: block;
            }
            #paginationDataPembukuan, #paginationDetailBarang, #paginationUtangPelanggan, #paginationUtangSaya {
                display: none;
            }
            #btnTambah-responsive-st {
                position: fixed;
                bottom: 30px;
                right: 32px;
                z-index: 9999; /* Jika perlu, sesuaikan indeks z sesuai kebutuhan */
            }
            #btnTambah-responsive-pb {
                display: block;
                position: fixed;
                bottom: 30px;
                right: 32px;
                z-index: 9999; /* Jika perlu, sesuaikan indeks z sesuai kebutuhan */
            }
            #opsiDiluarResponsive {
                display: none;
            }
            #opsiCatat {
                display: none;
            }   
            #btnUtangPelanggan {
                display: block;
            }
            #btnUtangSaya {
                display: block;
            }
        }
    </style>
</head>

<body>

    