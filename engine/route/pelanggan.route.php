<?php

class pelanggan extends Route{

    private $sn = 'pelangganData';
    private $su = 'utilityData';

    public function index()
    {
      $this -> bind('dasbor/pelanggan/pelanggan');
    }

    public function getDataPelanggan()
    {
      $requestData= $_REQUEST;
      $totalPelanggan = $this -> state($this -> sn) -> getJlhPelanggan();
      $dataPelanggan = $this -> state($this -> sn) -> getDataPelanggan($requestData);
      $data = array();

      foreach($dataPelanggan as $dp){
        $nestedData = array();
        $nestedData[] = $dp['nama'];
        $nestedData[] = $dp['alamat'];
        $nestedData[] = $dp['hp'];
        $nestedData[] = $dp['last_visit'];
        $nestedData[] = "0";
        $nestedData[] = "<a href='#!' class='btn btn-sm btn-primary'>Edit</a>";
        $data[] = $nestedData;
      }

      $json_data = array(
        "draw"            => intval( $requestData['draw'] ),  
        "recordsTotal"    => intval( $totalPelanggan ), 
        "recordsFiltered" => intval( $totalPelanggan ), 
        "data"            => $data );

      echo json_encode($json_data);
    }

    public function prosesTambahPelanggan()
    {
      $nama           = $this -> inp('nama');
      $alamat         = $this -> inp('alamat');
      $email          = $this -> inp('email');
      $hp             = $this -> inp('hp');
      $visit          = $this -> waktu();
      $idPelanggan    = $this -> rnint(8);
      //cek apakah ada nomor handphone & nama yang sama
      $jlhPelanggan   = $this -> state($this -> sn) -> getNamaHandphone($nama, $hp);
      if($jlhPelanggan > 0){
        $data['status'] = 'error';
      }else{
        $this -> state($this -> sn) -> tambahPelanggan($idPelanggan, $nama, $alamat, $hp, $email, $visit);
        $data['status'] = 'sukses';
      }
      $this -> toJson($data);
    }

}
