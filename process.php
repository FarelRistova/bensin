<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="s.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <?php
                class Shell {
                    protected $harga;
                    protected $jumlah;
                    protected $jenis;
                    protected $ppn;

                    public function __construct($harga, $jumlah, $jenis, $ppn) {
                        $this->harga = $harga;
                        $this->jumlah = $jumlah;
                        $this->jenis = $jenis;
                        $this->ppn = $ppn;
                    }

                    public function getTotal() {
                        $total = $this->harga * $this->jumlah;
                        $total += $total * ($this->ppn / 100); 
                        return $total;
                    }

                    public function getDetail() {
                        return "Jenis : " . $this->jenis . "<br>Harga : Rp. " . number_format($this->harga, 2, ',', '.') . "<br>Jumlah : " .
                        $this->jumlah . "<br>PPN (pajak) : " . $this->ppn . "%";
                    }
                }

                class Beli extends Shell {
                    public function __construct($harga, $jumlah, $jenis, $ppn) {
                        parent::__construct($harga, $jumlah, $jenis, $ppn);
                    }

                    public function buktiTransaksi() {
                        $total = $this->getTotal();
                        $output = "<div class='card shadow-sm mt-5'><div class='card-body'><h4 class='card-title mb-4'>BUKTI TRANSAKSI</h4>" . $this->getDetail() .
                                  "<br>Total Pembayaran: Rp <b> " . number_format($total, 2, ',', '.') . "</div></div>";
                        $output .= '<div class="text-center mt-4">
                                        <form action="form.html" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-secondary">
                                                <i class="bx bx-arrow-back"></i> ubah / pesan kembali
                                            </button>
                                        </form>
                                        <button onclick="window.print()" class="btn btn-primary">
                                            <i class="bx bx-printer"></i> cetak
                                        </button>
                                    </div>';
                                    
                        return $output;
                    }
                }

                $harga_shell = [
                    "Shell Super" => 15000,
                    "Shell V-Power" => 16000,
                    "Shell V-Power Diesel" => 18000,
                    "Shell V-Power Nitro" => 17000
                ];

                $ppn_default = 10;

                $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
                $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : null;

                if ($jenis !== null && $jumlah !== null && is_numeric($jumlah) && $jumlah > 0) {
                    $harga = isset($harga_shell[$jenis]) ? $harga_shell[$jenis] : 0;
                    $pembelian = new Beli($harga, $jumlah, $jenis, $ppn_default);
                    echo $pembelian->buktiTransaksi();
                } else {
                    echo '<div class="alert alert-danger" role="alert">Data yang dimasukkan tidak valid. <a href="form.html" class="alert-link">Kembali ke form</a></div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
