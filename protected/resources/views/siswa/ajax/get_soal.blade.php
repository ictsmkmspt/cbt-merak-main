<script src="{{ url('/lib/mathjax/2.7.2/MathJax.js?config=TeX-AMS_HTML')}}"></script>

<style type="text/css">
  .benar{
    padding: 15px;
    background: #045ff2;
    color: #fff;
  }
</style>
<?php
  if ($cek_jawaban != "") {
    $pilihan = $cek_jawaban->pilihan;
  }else{
    $pilihan = 'ER';
  }
?>

<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" style="position: absolute; top: 50%; left: 50%; margin: -50px 0px 0px -50px;">
    <div class="modal-header">
        <h5 style="color:#ff0000;">Please wait..</h5>
    </div>
    <div class="modal-body">
        <div id="ajax_loader">
            <img src="{{ url('/assets/assets/images/facebook.gif') }}">
        </div>
    </div>
</div>

<table class="table table-condensed" style="padding:0; margin: 0">
  <tbody>
    <tr>
      <input type="hidden" name="id_soaljawab" id="id_soaljawab" value="{{ $detailsoal->id_soal }}">
      <input type="hidden" name="id_soal{{ $detailsoal->id }}" id="id_soal{{ $detailsoal->id }}" value="{{ $detailsoal->id_soal }}">
      <input type="hidden" name="no_soal_id{{ $detailsoal->id }}" id="no_soal_id{{ $detailsoal->id }}" value="{{ $detailsoal->id }}">

      <!-- <td style="width: 15px">1</td> -->
      <td colspan="2" class="formula">
        <?php if($detailsoal->audio != ""){ $audio = $detailsoal->audio; ?>
          <div style="margin: 0 0 20px 0; padding: 15px; border: solid thin #a8a8a8;">
            <span style="color: #828282">Audio for Listening</span><hr style="margin: 8px 0 15px 0">
            <div class="clearfix"></div>
            <p>
              <audio controls>
              <source src="{{ url('/assets/audios/'.$audio) }}" type="audio/mpeg">
              Your browser does not support the audio element.
            </audio>
            </p>
          </div>
        <?php } ?>
        {!! $detailsoal->soal !!}
      </td>
    </tr>
    <tr id="wrap_pil_a" <?php if ($pilihan == 'A') { echo "class='benar'"; } ?>>
      <!-- <td>&nbsp;</td> -->
      <td style="width: 10px"><input type="radio" name="pilih{{ $detailsoal->id }}" value="A" data-toggle='tooltip' title="Klik untuk menjawab." <?php if ($pilihan == 'A') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pila !!} </td>
    </tr>
    <tr id="wrap_pil_b" <?php if ($pilihan == 'B') { echo "class='benar'"; } ?>>
      <!-- <td>&nbsp;</td> -->
      <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="B" data-toggle='tooltip' title="Klik untuk menjawab." <?php if ($pilihan == 'B') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pilb !!} </td>
    </tr>
    <tr id="wrap_pil_c" <?php if ($pilihan == 'C') { echo "class='benar'"; } ?>>
      <!-- <td>&nbsp;</td> -->
      <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="C" data-toggle='tooltip' title="Klik untuk menjawab." <?php if ($pilihan == 'C') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pilc !!} </td>
    </tr>
    <tr id="wrap_pil_d" <?php if ($pilihan == 'D') { echo "class='benar'"; } ?>>
      <!-- <td>&nbsp;</td> -->
      <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="D" data-toggle='tooltip' title="Klik untuk menjawab." <?php if ($pilihan == 'D') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pild !!} </td>
    </tr>
    <tr id="wrap_pil_e" <?php if ($pilihan == 'E') { echo "class='benar'"; } ?>>
      <!-- <td>&nbsp;</td> -->
      <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="E" data-toggle='tooltip' title="Klik untuk menjawab." <?php if ($pilihan == 'E') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pile !!} </td>
    </tr>
  </tbody>
</table>

<script>
      var renderMathJax = {
        formula: document.getElementsByClassName("formula"),

        update: function () {
          MathJax.Hub.Queue(["Typeset", MathJax.Hub, this.formula]);
        }
      };
      
      renderMathJax.update();
      $(document).ready(function(){
        $("input[name=pilih{{ $detailsoal->id }}]").click(function(){
          var pilihan = $("input[name=pilih{{ $detailsoal->id }}]:checked").val();
          var id_soal = $("#id_soal{{ $detailsoal->id }}").val();
          var no_soal_id = $("#no_soal_id{{ $detailsoal->id }}").val();
          var id_user = $("#id_user{{ $detailsoal->id }}").val();
          var datastring = "pilihan="+pilihan+"&id_soal="+id_soal+"&no_soal_id="+no_soal_id+"&id_user="+id_user;
          $('#pleaseWaitDialog').modal();
          $.ajax({
            type: "POST",
            url: "{!! url('simpanjawabankliksiswa') !!}",
            data: datastring,
            success: function(data){
              if (data == 'A') {
                $("#wrap_pil_b").removeClass('benar');
                $("#wrap_pil_c").removeClass('benar');
                $("#wrap_pil_d").removeClass('benar');
                $("#wrap_pil_e").removeClass('benar');
                $("#wrap_pil_a").addClass('benar');
              }else if(data == 'B'){
                $("#wrap_pil_a").removeClass('benar');
                $("#wrap_pil_c").removeClass('benar');
                $("#wrap_pil_d").removeClass('benar');
                $("#wrap_pil_e").removeClass('benar');
                $("#wrap_pil_b").addClass('benar');
              }else if(data == 'C'){
                $("#wrap_pil_b").removeClass('benar');
                $("#wrap_pil_a").removeClass('benar');
                $("#wrap_pil_d").removeClass('benar');
                $("#wrap_pil_e").removeClass('benar');
                $("#wrap_pil_c").addClass('benar');
              }else if(data == 'D'){
                $("#wrap_pil_b").removeClass('benar');
                $("#wrap_pil_c").removeClass('benar');
                $("#wrap_pil_a").removeClass('benar');
                $("#wrap_pil_e").removeClass('benar');
                $("#wrap_pil_d").addClass('benar');
              }else if(data == 'E'){
                $("#wrap_pil_b").removeClass('benar');
                $("#wrap_pil_c").removeClass('benar');
                $("#wrap_pil_d").removeClass('benar');
                $("#wrap_pil_a").removeClass('benar');
                $("#wrap_pil_e").addClass('benar');
              }
              $("#get-soal{{ $detailsoal->id }}").removeClass('page gradient').addClass('page active');
              $('#pleaseWaitDialog').modal('hide');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              // cbt simulasi sesi2 issued.
              // console.log ("simpanjawabankliksiswa status error");
              alert("simpan jawaban gagal, silahkan ulangi kembali jawaban yang benar");
              $('#pleaseWaitDialog').modal('hide');
            }
          })
        });
      });
    </script>