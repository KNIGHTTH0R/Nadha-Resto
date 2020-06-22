<?php

class menu extends Route{

    private $sn = 'menuData';

    public function index()
    {
        $data['menu'] = $this -> state($this -> sn) -> getMenu(); 
        $this -> bind('/dasbor/menu/menu', $data);
    }

    public function tambahMenu()
    {
        $data['kategori'] = $this -> state($this -> sn) -> getKategori();
        $this -> bind('/dasbor/menu/formTambahMenu', $data);
    }

    public function prosesTambahMenu()
    {
        //about img operation
        $sourcePath = $this -> getTempFile('txtFoto');
        $tipeGambar = array('png', 'jpg', 'jpeg');
        $namaFile = $this -> getNameFile('txtFoto');
        $tipeFile = $this -> getTypeFile($namaFile);
        $sizeFile = $this -> getSizeFile('txtFoto');
        //data operation
        // let foto = document.getElementById('txtFoto').value;
        // let nama = document.getElementById('txtNama').value;
        // let kategori = document.getElementById('txtKategori').value;
        // let deks = document.getElementById('txtDeks').value;
        // let harga = document.getElementById('txtHarga').value;
        // let satuan = document.getElementById('txtSatuan').value;

        $kdMenu = $this -> rnint(8);
        $nama = $this -> inp('txtNama');
        $deks = $this -> inp('txtDeks');
        $harga = $this -> inp('txtHarga');
        $satuan = $this -> inp('txtSatuan');
        $kategori = $this -> inp('txtKategori');
        $picName = $kdMenu.".".$tipeFile;

        $destination = 'ladun/dasbor/img/menu/'.$kdMenu.".".$tipeFile;

        if(in_array($tipeFile, $tipeGambar)){
            if($sizeFile > 2044070){
                $data['status'] = 'error_size_file';
            }else{
                $data['status'] = 'success';
                $this -> uploadFile($sourcePath, $destination);
                $this -> state('menuData') -> prosesTambahMenu($kdMenu, $nama, $deks, $kategori, $satuan, $harga, $picName);
            }
        }else{
            $data['status'] = 'error_tipe_file';
        }

        $data['sumber'] = $destination;
        $this -> toJson($data);
    }

}