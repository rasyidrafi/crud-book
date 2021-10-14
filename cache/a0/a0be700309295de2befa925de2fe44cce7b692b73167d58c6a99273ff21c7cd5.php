<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* pages/index.phtml */
class __TwigTemplate_572fcbe69ed599fc69d594bf58cc08f2b4e74c22aa698fb5c72801e3fa5989ac extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<?php
include(\"function/conn.php\");
include(\"function/useful.php\");
\$userDataTemp = [];
\$getuser = \$db->select()->from(\"transaksi\")->findAll();
foreach (\$getuser as \$user) {
    \$user = (array)\$user;
    \$totalBuku = 0;
    \$totalHarga = 0;
    \$detailData = \$db->select()->from(\"detail_transaksi\")->where(\"id_transaksi\", \"=\", \$user[\"id\"])->findAll();
    \$dataBuku = [];
    foreach (\$detailData as \$detail) {
        \$detail = (array)\$detail;
        \$totalHarga = \$totalHarga + \$detail[\"total\"];
        \$totalBuku = \$totalBuku + \$detail[\"jumlah\"];
        array_push(\$dataBuku, \$detail);
    }

    array_push(\$userDataTemp, [
        \"id\" => \$user[\"id\"],
        \"nama_pembeli\" => \$user[\"nama_pembeli\"],
        \"created_at\" => \$user[\"created_at\"],
        \"uang_bayar\" => \$user[\"uang_bayar\"],
        \"totalBuku\" => \$totalBuku,
        \"totalHarga\" => \$totalHarga,
        \"dataBuku\" => \$dataBuku
    ]);
}

?>

<!DOCTYPE html>
<html lang=\"en\">
<?php include(\"public/layout/_head.php\"); ?>

<body>
    <?php include(\"public/components/navbar.php\") ?>
    <style>
        .cb {
            min-height: 156px;
            overflow-y: auto;
        }

        .total-title {
            border-bottom: solid 2px black;
        }
    </style>

    <div class=\"container py-4\">
        <div class=\"card\">
            <div class=\"card-body cb\">
                <div class=\"d-flex justify-content-between align-items-center mb-2\">
                    <span class=\"fw-bold text-primary\">Data Pembeli</span>
                    <a href=\"/add\" class=\"btn btn-sm btn-primary\">+ Tambah Data</a>
                </div>

                <div class=\"card border-0\">
                    <div class=\"card-body overflow-auto\">
                        <table class=\"pt-2 table-striped table table-bordered table-hover table-sm\" id=\"book-table\">
                            <thead>
                                <tr class=\"text-primary\" style=\"text-transform: uppercase;\">
                                    <th>No</th>
                                    <th>Id</th>
                                    <th>Nama Pembeli</th>
                                    <th>Total Buku</th>
                                    <th>Total Harga</th>
                                    <th>Waktu</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php \$totalBukuHold = 0; ?>
                                <?php for (\$i = 0; \$i < count(\$userDataTemp); \$i++) : ?>
                                    <?php \$userData = (array)\$userDataTemp[\$i]; ?>
                                    <tr>
                                        <td><?php echo \$i + 1; ?></td>
                                        <td><?php echo \$userData[\"id\"]; ?></td>
                                        <td><?php echo \$userData[\"nama_pembeli\"]; ?></td>
                                        <td>
                                            <?php
                                            \$totalBukuNow = (int)\$userData[\"totalBuku\"];
                                            \$totalBukuHold = \$totalBukuHold + \$totalBukuNow;
                                            echo \$totalBukuNow;
                                            ?>
                                        </td>
                                        <td><?php echo rupiah(\$userData[\"totalHarga\"]); ?></td>
                                        <td><?php echo \$userData[\"created_at\"]; ?></td>
                                        <td>
                                            <div class=\"btn-group btn-group-sm\"></div>
                                            <button onclick='renderModal(`<?php echo json_encode([\$userData[\"dataBuku\"], \$userData[\"uang_bayar\"]]) ?>`)' class=\"btn btn-sm btn-success\">Detail</button>
                                            <button onclick='renderDelete(`<?php echo \$userData[\"id\"]; ?>`)' class=\"btn-sm btn-danger btn\">Delete</button>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"row mt-3\">
            <div class=\"col-md-6 mb-3\">
                <div class=\"card\">
                    <div class=\"card-body cb\">
                        <h5 class=\"fw-bold total-title\">Total Buku Terjual :</h5>
                        <h1 class=\"fw-bold\" id=\"totalTerjual\"><?= \$totalBukuNow  ?></h1>
                    </div>
                </div>
            </div>
            <div class=\"col-md-6 mb-3\">
                <div class=\"card\">
                    <div class=\"card-body cb\">
                        <h5 class=\"fw-bold total-title\">Total Pembelian : </h5>
                        <h1 class=\"fw-bold text-end\" id=\"totalHargaAll\">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL SECTION -->

    <div id=\"detail-modal\" class=\"modal fade\" tabindex=\"-1\">
        <div class=\"modal-dialog modal-lg modal-dialog-centered\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"modal-detail-title\">Transaksi NOTA-<span id=\"id-trns-modal\">0</span></h5>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                <div class=\"modal-body\">
                    <h4 class=\"fw-bold text-center\">Lamda Book Store</h4>
                    <span class=\"text-center d-block px-4\">Perumahan Griya Shanta Permata, N-524, Mojolangu, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141</span>
                    <div class=\"table-responsive\">
                        <table class=\"table table-hover\">
                            <thead>
                                <tr>
                                    <th>ID Buku</th>
                                    <th>Nama Buku</th>
                                    <th>Jumlah</th>
                                    <th>Diskon</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id=\"modal-tbody\"></tbody>
                        </table>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h5>Total Harga : <span class=\"text-danger fw-bold\" id=\"totalHarga\">Rp. 0</span></h5>
                        </div>
                        <div class=\"col-md-6 text-end\">
                            <h5>Total Bayar : <span class=\"text-danger fw-bold\" id=\"totalBayar\">Rp. 0</span></h5>
                        </div>
                        <div class=\"text-end\">
                            <h5>Kembalian : <span class=\"fw-bold\" id=\"totalKembali\">Rp. 0</span></h5>
                        </div>
                    </div>
                    <span>Transaksi dilakukan pada : <span class=\"fw-bold\" id=\"tgl-transaksi\"></span></span>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                    <form action=\"/print\" method=\"post\">
                        <input type=\"hidden\" name=\"jsonData\" value='' id=\"hiddenPrint\">
                        <button type=\"submit\" class=\"btn btn-primary\">Print Nota</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class=\"modal fade\" id=\"delete-modal\" tabindex=\"-1\" aria-hidden=\"true\">
        <div class=\"modal-dialog modal-dialog-centered\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\">Hapus Transaksi</h5>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                <div class=\"modal-body text-center\">
                    <h2 class=\"text-danger fw-bold\">Warning!</h2>
                    <span class=\"d-block px-2 text-secondaary\">Aksi ini akan menghapus data dalam database, aksi ini tidak dapat diurungkan</span>
                    <br>
                    <span>ID Transaksi : </span>
                    <input type=\"text\" readonly id=\"id-del-hold\" class=\"text-center form-control mt-2\">
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Batal</button>
                    <button onclick=\"del()\" type=\"button\" class=\"btn btn-danger\">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <?php include(\"public/layout/_script.php\") ?>
    <script src=\"js/index.js\"></script>
</body>

</html>";
    }

    public function getTemplateName()
    {
        return "pages/index.phtml";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/index.phtml", "/opt/lampp/htdocs/crud-book/public/pages/index.phtml");
    }
}
