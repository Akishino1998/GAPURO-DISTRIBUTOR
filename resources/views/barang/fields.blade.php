@section('css')
	<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
    #container {
        margin: 5px 20px 20px 20px auto;
    }
    .ck-editor__editable[role="textbox"] {
        min-height: 200px;
    }
    .ck-content .image {
        max-width: 80%;
        margin: 20px auto;
    }
    .imagePreview {
        width: 100%;
        height: 180px;
        background-position: center center;
        background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
        background-color:#fff;
        background-size: cover;
        background-repeat:no-repeat;
        display: inline-block;
        box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
    }
    .btn-upload {
        display:block;
        border-radius:0px;
        box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
        margin-top:-5px;
        background: #EE9D01 !important;
        color: white;
    }
    .imgUp {
        margin-bottom:15px;
    }
    .del {
        position:absolute;
        top:0px;
        right:15px;
        width:30px;
        height:30px;
        text-align:center;
        line-height:30px;
        background-color:rgba(255,255,255,0.6);
        cursor:pointer;
    }
    .imgAdd {
        width:20px;
        height:40px;
        border-radius:50%;
        background-color:#705ec8;
        color:#fff;
        box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);
        text-align:center;
        line-height:30px;
        margin-top:0px;
        cursor:pointer;
        font-size:15px;
    }
    .select2-container .select2-selection--single {
        height: 35px;
    }
    </style>
@endsection
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><a href="{{ route('barang.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a> <strong>Tambah Baru Data Barang</strong></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label class="form-label"> Foto Barang</label>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3 imgUp">
                        <div class="imagePreview"></div>
                        <label class="btn btn-upload"> Upload
                            <input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px" name="galeri" accept="image/png, image/jpeg" > 
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                <label class="form-label"> Kategori <span class="badge bg-primary">Wajib</span></label>
                <select class="form-control select2-merk"  data-placeholder="Pilih Kategori" style="width: 100%" name="id_kategori" required>
                    <option value="">--- Pilih Kategori ---</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-12" style="margin-bottom: 0px !important">
                <label for="nama_part" class="form-label">Nama Barang <span class="badge bg-primary">Wajib</span></label>
                {!! Form::text('nama_barang', null, ['class' => 'form-control','maxlength' => 150,'maxlength' => 150,'required'=>"true",'autocomplete'=>"off"]) !!}
                <p class=" mt-1">
                    Cantumkan min. 20 karakter terdiri dari jenis produk, merek, dan keterangan seperti warna, bahan, atau tipe agar mudah ditemukan.
                </p>
            </div>

            {{-- <div class="form-group col-sm-12">
                <label class="form-label"> Merk</label>
                <select class="form-control select2-merk" data-placeholder="Pilih Merk" name="id_merk">
                    <option value="">--- Pilih Merk ---</option>
                    @foreach ($merk as $item)
                        <option value="{{ $item->id }}">{{ $item->merk }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="form-group col-sm-12">
                <label class="form-label"> Satuan <span class="badge bg-primary">Wajib</span></label>
                <select class="form-control select2-merk" data-placeholder="Pilih Satuan" name="id_satuan" required>
                    <option value="">--- Pilih Satuan ---</option>
                    @foreach ($satuan as $item)
                        <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="form-group col-sm-12">
                <label for="warna" class="form-label">Harga Jual Umum<span class="badge bg-primary">Wajib</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            Rp
                        </div>
                    </div>
                    <input class="form-control uang" placeholder="Harga Jual" type="text" id="harga" name="harga_jual" required>
                </div>
            </div> --}}
            <div class="form-group col-sm-12 col-lg-12">
                <label class="form-label"> Deskripsi </label>
                <textarea name="deskripsi" id="editor"  cols="30" rows="5" class="form-control"></textarea>
                <p class=" mt-1">
                    Pastikan deskripsi produk memuat penjelasan detail terkait produkmu agar pembeli mudah mengerti dan menemukan produkmu.
                </p>
            </div>
            
        </div>
    </div>
</div>
<div class="card">
    <div class="card-footer">
        <button class="btn btn-primary text-white" type="submit" style="width: 100%"> <i class="fas fa-save    "></i> Simpan</button>
    </div>
</div>
@section('js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
        ClassicEditor.create(document.getElementById("editor"), {
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                    'removeFormat', '|',
                    'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'blockQuote', 'insertTable', 'codeBlock', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
        });
        let showTableHead = true;
        setTimeout(bottomAddImg, 500);
        function bottomAddImg(){
            $(".imgAdd").click(function(){
                $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-6 col-md-4 col-lg-3  imgUp"><div class="imagePreview"></div><label class="btn btn-upload">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;" name="galeri[]"></label><i class="fa fa-times del delete'+idGambar +'" onclick="removeUploadImg('+idGambar++ +')"></i></div>');
            });
        }
        $(function() {
            $(document).on("change",".uploadFile", function(){
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function(){ // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");

                    }
                }
            });
        });
        let idGambar = 1;
        function removeUploadImg(id){
            $(".delete"+id).parent().remove();
        }
        
        $(document).ready(function() {
	        'use strict';
            $('.select2-merk').select2({
                width: '100%',
                placeholder: "Pilih",
                tags: true
            });
            $('.uang').mask('000.000.000.000', {
                reverse: true
            });
            
        });
        $(document).on('mouseenter', '.divbutton', function () {
            }).on('click', '.divbutton', function() {
                console.log(1);
                $(this).parent().parent().remove();
            });
    </script>
@endsection