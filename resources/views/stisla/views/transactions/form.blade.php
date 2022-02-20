@extends('stisla.layouts.app')

@section('title')
  {{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title = 'Siswa' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('mahasiswas.index') }}">{{ __('Siswa') }}</a>
      </div>
      <div class="breadcrumb-item">{{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h4>Rekam &amp; Daftar Transaksi</h4>

              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <form name="transaksi" action="simpan_transaksi_pra_multi.php?pages=XAC6XD7wL6JF1TLdLFJlnM1gUPgjzq3M45wd8h41M7fMic2qHL3Hv39ijR8YXlO8GvxF5iFyJXfpZgs6DtDwyyVY16IC51w1T1F5&amp;nis=210001&amp;max=8674&amp;username=tri&amp;tanggal=2022-02-20&amp;tahun=
                                                        2021/2022&amp;act=save" method="post">
                    <table border="0" cellspacing="0" cellpadding="0" id="example1" class="table font dataTable">
                      <tbody>
                        <tr bgcolor="#8FBC8F">
                          <td width="86" class=""><strong class="danger">Nama</strong></td>
                          <td width="18" class=""><strong class="danger">:</strong></td>
                          <td width="296" class=""><strong class="danger">Achmad Habsy Daffa Syah</strong></td>
                        </tr>
                        <tr>
                          <td>NIS</td>
                          <td>:</td>
                          <td>210001</td>
                        </tr>
                        <tr>
                          <td>Kelas</td>
                          <td>:</td>
                          <td>7-A</td>
                        </tr>

                        <tr>
                          <td>No HP</td>
                          <td>:</td>
                          <td>---&nbsp;&nbsp;<br><a href="seting_smsapi.php?pages=XAC6XD7wL6JF1TLdLFJlnM1gUPgjzq3M45wd8h41M7fMic2qHL3Hv39ijR8YXlO8GvxF5iFyJXfpZgs6DtDwyyVY16IC51w1T1F5&amp;nis=210001&amp;max=8674&amp;username=tri&amp;tanggal=2022-02-20&amp;tahun=
                                                             2021/2022"></a></td>
                        </tr>
                        <tr>
                          <td>E-mail</td>
                          <td>:</td>
                          <td>--- </td>
                        </tr>
                      </tbody>
                    </table>

                    <table border="0" cellspacing="0" cellpadding="0" id="example2" class="table table-responsive">
                      <tbody>
                        <tr>
                          <td>
                            <strong class="text-danger">Pilih Jenis Pembayaran :</strong>
                            <select class="form-control select2 font" style="width: 100%;" name="nama_bayar" placeholder="Pilih Jenis Pembayaran" required="">
                              <option class="col-xs-10 success font"></option>
                              <option class="col-xs-12 primary text-primary font" value="SPP">SPP [ 0 / Bulan ] -- (Kurang : -80.000)</option>
                              <option class="col-xs-12 primary text-primary font" value="SARPRAS">SARPRAS -- (Kurang : 0)</option>
                              <option class="col-xs-12 primary text-primary font" value="TEST">TEST -- (Kurang : 180.000)</option>
                              <option class="col-xs-12 primary text-primary font" value="LKS">LKS -- (Kurang : 244.000)</option>
                              <option class="col-xs-12 primary text-primary font" value="UJIAN">UJIAN -- (Kurang : 0)</option>
                              <option class="col-xs-12 primary text-primary font" value="Tanggungan Tahun lalu [SPP]">Tanggungan Tahun lalu [SPP] -- (Kurang : 0)</option>
                              <option class="col-xs-12 primary text-primary font" value="Tanggungan Tahun lalu [SARPRAS]">Tanggungan Tahun lalu [SARPRAS] -- (Kurang : 0)</option>
                              <option class="col-xs-12 primary text-primary font" value="Tanggungan Tahun lalu [TEST]">Tanggungan Tahun lalu [TEST] -- (Kurang : 0)</option>
                              <option class="col-xs-12 primary text-primary font" value="Tanggungan Tahun lalu [LKS]">Tanggungan Tahun lalu [LKS] -- (Kurang : 0)</option>
                              <option class="col-xs-12 primary text-primary font" value="Tanggungan Tahun lalu [UJIAN]">Tanggungan Tahun lalu [UJIAN] -- (Kurang : 0)</option>
                            </select>
                          </td>

                        </tr>
                        <tr>
                          <td>
                            <strong class="text-danger">Metode Pembayaran :</strong>
                            <label class="radio-inline">
                              <input type="radio" name="metode" class="font" id="optionsRadiosInline1" value="" checked="">Langsung [Tunai]</label>
                            <label class="radio-inline">
                              <input type="radio" name="metode" class="font" id="optionsRadiosInline2" value="bank">Rekening [Transfer Bank]</label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <input type="text" class="form-control font" placeholder="Catatan Pembayaran (Optional)" name="catatan" style="text-align:left">
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <div class="col-md-12">
                      <table id="example2" class="table table-responsive">
                        <tbody>
                          <tr>
                            <td>
                              <input type="text" class="form-control font" placeholder="Tanggal Bayar" id="tanggal1" value="20/02/2022" name="tanggal" style="text-align:center" required="" disabled="">
                              <a
                                href="rekam_transaksi2.php?pages=XAC6XD7wL6JF1TLdLFJlnM1gUPgjzq3M45wd8h41M7fMic2qHL3Hv39ijR8YXlO8GvxF5iFyJXfpZgs6DtDwyyVY16IC51w1T1F5&amp;act=rec&amp;tahun=2021/2022&amp;username=tri&amp;nis=210001"><span
                                  class="text-success font2"> <i>Tanggal Lain? Klik disini</i></span></a>
                            </td>
                            <td>
                              <input type="text" class="form-control font" placeholder="Jumlah Bayar" name="jumlah" style="text-align:right" id="inputku" onkeydown="return numbersonly(this, event);"
                                onkeyup="javascript:tandaPemisahTitik(this);" required="">
                            </td>
                            <td>
                              <div class="form-group has-error">
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-save"> SIMPAN</span></button>

                              </div>
                              <div class="form-group has-error">

                              </div>
                            </td>
                          </tr>
                          {{-- <tr>
                            <td colspan="3">
                              <h5>
                                <p class="text-danger"><span class="glyphicon glyphicon-warning-sign"></span> Pembayaran yang sifatnya Bulanan, Perekaman dilakukan per Bulan (meskipun dibayarkan
                                  secara rapel)</p>
                              </h5>
                            </td>
                          </tr> --}}
                        </tbody>
                      </table>
                    </div>
                  </form>

                  <div class="col-md-12">
                    <h4 class="text-red"><strong> Daftar Transaksi</strong></h4>
                    <h3 class="font3">
                      <a>

                        <button type="button" class="btn btn-github btn-sm" title="Cetak"><span class="glyphicon glyphicon-print"><i class="font"> CETAK</i></span></button>
                      </a>
                      &nbsp;&nbsp;
                      TOTAL :<strong class="text-danger">
                        0,- </strong>
                    </h3><br>
                    <table id="example2" class="table table-condensed font">


                    </table>
                    <table id="example2" class="table table-condensed font">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>NIS</th>
                          <th>Kls</th>
                          <th>Jns</th>
                          <th>Jumlah</th>
                          <th width="150">Aksi</th>
                        </tr>
                      </thead>


                    </table>



                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h4>Daftar Tanggungan</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="table-responsive">
                    <div class="col-xs-12">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>No</th>
                            {{-- <th>Kode</th> --}}
                            <th>Nama Tanggungan</th>
                            <th align="right">Tanggungan</th>
                            <th align="right">Terbayar</th>
                            <th>Kurang</th>
                          </tr>
                        </thead>
                        <tbody>

                          <tr>
                            <td align="center">1</td>
                            {{-- <td>A</td> --}}
                            <td>SPP</td>
                            <td align="right">0<br><b class="text-danger">0 / Bulan</b></td>
                            <td align="right">80.000<br><b class="text-danger">12 Bulan
                              </b></td>
                            <td align="right">-80.000<br><b class="text-danger">inf Bulan
                              </b></td>
                          </tr>

                          <tr>
                            <td align="center">2</td>
                            {{-- <td>B</td> --}}
                            <td>SARPRAS</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                          </tr>

                          <tr>
                            <td align="center">3</td>
                            {{-- <td>C</td> --}}
                            <td>TEST</td>
                            <td align="right">180.000</td>
                            <td align="right">0</td>
                            <td align="right">180.000</td>
                          </tr>

                          <tr>
                            <td align="center">4</td>
                            {{-- <td>D</td> --}}
                            <td>LKS</td>
                            <td align="right">244.000</td>
                            <td align="right">0</td>
                            <td align="right">244.000</td>
                          </tr>

                          <tr>
                            <td align="center">5</td>
                            {{-- <td>E</td> --}}
                            <td>UJIAN</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                          </tr>

                          <tr>
                            <td align="center">6</td>
                            {{-- <td>F</td> --}}
                            <td>Tanggungan Tahun lalu [SPP]</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                          </tr>

                          <tr>
                            <td align="center">7</td>
                            {{-- <td>G</td> --}}
                            <td>Tanggungan Tahun lalu [SARPRAS]</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                          </tr>

                          <tr>
                            <td align="center">8</td>
                            {{-- <td>H</td> --}}
                            <td>Tanggungan Tahun lalu [TEST]</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                          </tr>

                          <tr>
                            <td align="center">9</td>
                            {{-- <td>I</td> --}}
                            <td>Tanggungan Tahun lalu [LKS]</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                          </tr>

                          <tr>
                            <td align="center">10</td>
                            {{-- <td>J</td> --}}
                            <td>Tanggungan Tahun lalu [UJIAN]</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                            <td align="right">0</td>
                          </tr>

                          <tr>
                            <td colspan="2" align="center"><strong class="text-warning">JUMLAH</strong></td>
                            <td align="right"><strong class="text-warning">424.000</strong></td>
                            <td align="right"><strong class="text-warning">80.000</strong></td>
                            <td align="right"><strong class="text-warning">344.000</strong></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Riwayat Transaksi</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-xs-12 table-responsive">
                    <table id="example2" class="table table-striped  text-success">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Nama</th>
                          <th>NIS</th>
                          <th>Kelas</th>
                          <th>Jenis</th>
                          <th>Jumlah</th>
                          <th>Penerima</th>
                        </tr>
                      </thead>
                      <tbody>

                        <tr>
                          <td align="center">1</td>
                          <td>19-08-2021</td>
                          <td>Achmad Habsy Daffa Syah</td>
                          <td>210001</td>
                          <td>7-A</td>
                          <td>A</td>
                          <td>80.000</td>
                          <td>CACA NIKITA DEWI</td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <style>
            .versi {
              font-family: consolas;
              font-size: 13px;
              color: #F00;
            }

            .blink {
              animation: blink-animation 1s steps(5, start) infinite;
              -webkit-animation: blink-animation 1s steps(5, start) infinite;
            }

            @keyframes blink-animation {
              to {
                visibility: hidden;
              }
            }

            @-webkit-keyframes blink-animation {
              to {
                visibility: hidden;
              }
            }

          </style>

        </div>
      </div>

    </div>
  </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
