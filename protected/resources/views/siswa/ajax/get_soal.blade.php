<script src="{{ url('/lib/mathjax/2.7.2/MathJax.js?config=TeX-AMS_HTML')}}"></script>

<style type="text/css">
  .benar {
    padding: 15px;
    background: #045ff2;
    color: #fff;
  }
  /* ESSAY */
  .essay-wrap {
    margin-top: 14px;
    padding: 16px;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
  }
  .essay-label {
    font-size: 12px; font-weight: 600; color: #475569;
    margin-bottom: 8px; display: block;
  }
  .essay-textarea {
    width: 100%; min-height: 140px;
    padding: 10px 13px;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: 13px; color: #1e293b;
    font-family: inherit; resize: vertical;
    transition: border .2s; outline: none;
    background: #fff;
  }
  .essay-textarea:focus { border-color: #3b82f6; }
  .essay-saved {
    font-size: 11.5px; color: #059669;
    margin-top: 6px; display: none;
  }
  .essay-bobot {
    display: inline-block;
    background: #fef3c7; color: #d97706;
    border-radius: 6px; padding: 3px 10px;
    font-size: 11px; font-weight: 700;
    margin-top: 10px;
  }
  .essay-badge {
    display: inline-block;
    background: #f59e0b; color: #fff;
    border-radius: 5px; padding: 2px 8px;
    font-size: 11px; font-weight: 700;
    margin-left: 6px;
  }
</style>

<?php
  $tipe          = isset($detailsoal->tipe) ? $detailsoal->tipe : 'pg';
  $bobot         = isset($detailsoal->bobot) ? $detailsoal->bobot : 10;
  $jawaban_essay = '';

  if ($cek_jawaban != "") {
    $pilihan       = $cek_jawaban->pilihan;
    $jawaban_essay = isset($cek_jawaban->jawaban_essay) ? $cek_jawaban->jawaban_essay : '';
  } else {
    $pilihan = 'ER';
  }
?>

<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"
  style="position: absolute; top: 50%; left: 50%; margin: -50px 0px 0px -50px;">
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
      <input type="hidden" name="tipe_soal{{ $detailsoal->id }}" id="tipe_soal{{ $detailsoal->id }}" value="{{ $tipe }}">

      <td colspan="2" class="formula">
        <?php if($detailsoal->audio != ""){ $audio = $detailsoal->audio; ?>
          <div style="margin: 0 0 20px 0; padding: 15px; border: solid thin #a8a8a8;">
            <span style="color: #828282">Audio for Listening</span>
            <hr style="margin: 8px 0 15px 0">
            <audio controls>
              <source src="{{ url('/assets/audios/'.$audio) }}" type="audio/mpeg">
            </audio>
          </div>
        <?php } ?>
        {!! $detailsoal->soal !!}
        @if($tipe == 'essay')
          <span class="essay-badge">✏️ Essay</span>
        @endif
      </td>
    </tr>

    {{-- ===== PILIHAN GANDA ===== --}}
    @if($tipe == 'pg')
    <tr id="wrap_pil_a" <?php if ($pilihan == 'A') { echo "class='benar'"; } ?>>
      <td style="width: 10px">
        <input type="radio" name="pilih{{ $detailsoal->id }}" value="A"
          data-toggle='tooltip' title="Klik untuk menjawab."
          <?php if ($pilihan == 'A') { echo "checked"; } ?>>
      </td>
      <td class="formula">{!! $detailsoal->pila !!}</td>
    </tr>
    <tr id="wrap_pil_b" <?php if ($pilihan == 'B') { echo "class='benar'"; } ?>>
      <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="B"
        data-toggle='tooltip' title="Klik untuk menjawab."
        <?php if ($pilihan == 'B') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pilb !!}</td>
    </tr>
    <tr id="wrap_pil_c" <?php if ($pilihan == 'C') { echo "class='benar'"; } ?>>
      <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="C"
        data-toggle='tooltip' title="Klik untuk menjawab."
        <?php if ($pilihan == 'C') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pilc !!}</td>
    </tr>
    <tr id="wrap_pil_d" <?php if ($pilihan == 'D') { echo "class='benar'"; } ?>>
      <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="D"
        data-toggle='tooltip' title="Klik untuk menjawab."
        <?php if ($pilihan == 'D') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pild !!}</td>
    </tr>
    <tr id="wrap_pil_e" <?php if ($pilihan == 'E') { echo "class='benar'"; } ?>>
      <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="E"
        data-toggle='tooltip' title="Klik untuk menjawab."
        <?php if ($pilihan == 'E') { echo "checked"; } ?>></td>
      <td class="formula">{!! $detailsoal->pile !!}</td>
    </tr>

    {{-- ===== ESSAY ===== --}}
    @else
    <tr>
      <td colspan="2">
        <div class="essay-wrap">
          <label class="essay-label">✏️ Tulis jawaban kamu di bawah ini:</label>
          <textarea
            class="essay-textarea"
            id="essay_jawab{{ $detailsoal->id }}"
            placeholder="Ketik jawaban kamu di sini..."
          >{{ $jawaban_essay }}</textarea>
          <div class="essay-saved" id="essay_saved{{ $detailsoal->id }}">
            ✅ Jawaban tersimpan otomatis
          </div>
          <div class="essay-bobot">📊 Bobot: {{ $bobot }} poin</div>
        </div>
      </td>
    </tr>
    @endif

  </tbody>
</table>

<script>
var renderMathJax = {
  formula: document.getElementsByClassName("formula"),
  update: function() { MathJax.Hub.Queue(["Typeset", MathJax.Hub, this.formula]); }
};
renderMathJax.update();

$(document).ready(function(){
  var tipe = $("#tipe_soal{{ $detailsoal->id }}").val();

  if (tipe === 'pg') {
    // ===== HANDLER PILIHAN GANDA =====
    $("input[name=pilih{{ $detailsoal->id }}]").click(function(){
      var pilihan    = $("input[name=pilih{{ $detailsoal->id }}]:checked").val();
      var id_soal    = $("#id_soal{{ $detailsoal->id }}").val();
      var no_soal_id = $("#no_soal_id{{ $detailsoal->id }}").val();
      var datastring = "pilihan="+pilihan+"&id_soal="+id_soal+"&no_soal_id="+no_soal_id;
      $('#pleaseWaitDialog').modal();
      $.ajax({
        type: "POST",
        url: "{!! url('simpanjawabankliksiswa') !!}",
        data: datastring,
        success: function(data){
          $("#wrap_pil_a,#wrap_pil_b,#wrap_pil_c,#wrap_pil_d,#wrap_pil_e").removeClass('benar');
          if (data=='A')      $("#wrap_pil_a").addClass('benar');
          else if (data=='B') $("#wrap_pil_b").addClass('benar');
          else if (data=='C') $("#wrap_pil_c").addClass('benar');
          else if (data=='D') $("#wrap_pil_d").addClass('benar');
          else if (data=='E') $("#wrap_pil_e").addClass('benar');
          $("#get-soal{{ $detailsoal->id }}").removeClass('page gradient').addClass('page active');
          $('#pleaseWaitDialog').modal('hide');
        },
        error: function(){
          alert("Simpan jawaban gagal, silahkan ulangi kembali.");
          $('#pleaseWaitDialog').modal('hide');
        }
      });
    });

  } else {
    // ===== HANDLER ESSAY — auto-save debounce 1.5 detik =====
    var essayTimer{{ $detailsoal->id }};
    $("#essay_jawab{{ $detailsoal->id }}").on('input', function(){
      clearTimeout(essayTimer{{ $detailsoal->id }});
      var textarea = $(this);
      essayTimer{{ $detailsoal->id }} = setTimeout(function(){
        var jawaban    = textarea.val();
        var id_soal    = $("#id_soal{{ $detailsoal->id }}").val();
        var no_soal_id = $("#no_soal_id{{ $detailsoal->id }}").val();
        $.ajax({
          type: "POST",
          url: "{!! url('simpan-jawaban-essay') !!}",
          data: {
            jawaban_essay : jawaban,
            id_soal       : id_soal,
            no_soal_id    : no_soal_id
          },
          success: function(res){
            if (res === 'ok') {
              $("#essay_saved{{ $detailsoal->id }}").fadeIn(200).delay(2000).fadeOut(400);
              // Tandai nomor soal sebagai sudah dijawab
              $("#get-soal{{ $detailsoal->id }}").removeClass('page gradient').addClass('page active');
            }
          }
        });
      }, 1500);
    });
  }
});
</script>
