<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>SIM NOTE-R</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <!-- Sweet Alert -->
  <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
  <script src="/assets/js/jquery-2.1.1.js"></script>
  <style>
  * {
    font-family: Verdana, Arial, sans-serif;
  }
  a:link {
    color:#000;
    text-decoration: none;
  }
  a:visited {
    color:#000;
  }
  a:hover {
    color:#33F;
  }
  .button {
    background: -webkit-linear-gradient(top,#008dfd 0,#0370ea 100%);
    border: 1px solid #076bd2;
    border-radius: 3px;
    color: #fff;
    display: none;
    font-size: 13px;
    font-weight: bold;
    line-height: 1.3;
    padding: 8px 25px;
    text-align: center;
    text-shadow: 1px 1px 1px #076bd2;
    letter-spacing: normal;
  }
  .center {
    padding: 10px;
    text-align: center;
  }
  .final {
    color: black;
    padding-right: 3px; 
  }
  .interim {
    color: gray;
  }
  .info {
    font-size: 14px;
    text-align: center;
    color: #777;
    display: none;
  }
  .right {
    float: right;
  }
  .sidebyside {
    display: inline-block;
    width: 45%;
    min-height: 40px;
    text-align: left;
    vertical-align: top;
  }
  #headline {
    font-size: 40px;
    font-weight: 300;
  }
  #info {
    font-size: 20px;
    text-align: center;
    color: #777;
    visibility: hidden;
  }
  #results {
    font-size: 14px;
    font-weight: bold;
    border: 1px solid #ddd;
    padding: 15px;
    text-align: left;
    min-height: 150px;
  }
  #start_button {
    border: 0;
    background-color:transparent;
    padding: 0;
  }
</style>
</head>

<body style="background-color: #f8f8f8;">
  <div class="container" style="background-color: white; min-height: 1024px">
    <div class="row">
      <div class="col-sm-3" style="min-height:100%;border-right: 2px; border-left: 0;border-top: 0;border-bottom: 0; border-style: solid; border-color: #ddd;">
        <h3>Peserta Rapat</h3>
      </div>
      <div class="col-sm-9">
        <h3>Isi Rapat</h3>
        <div id="info">
          <p id="info_start">Klik icon microfon sebelum berbicara</p>
          <p id="info_speak_now">Bicara Sekarang.</p>
          <p id="info_no_speech">Tidak ada suara terdeteksi. Anda mungkin perlu menyesuaikan.
            <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">
            Pengaturan Microfon</a>.</p>
            <p id="info_no_microphone" style="display:none; font-size: 12px;">
              Tidak ada microfon ditemukan. Pastikan mikrofon telah dipasang.
              <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">
              microphone settings</a> are configured correctly.</p>
              <p id="info_allow" style="font-size: 12px;">Klik tombol "Izinkan" untuk mengaktifkan microfon.</p>
              <p id="info_denied" style="font-size: 12px;">Izin penggunaan microfon dibutuhkan.</p>
              <p id="info_blocked" style="font-size: 12px;">Izin penggunaan microfon diblokir. Untuk mengganti pergi ke chrome://settings/contentExceptions#media-stream</p>
              <p id="info_upgrade" style="font-size: 12px;">Browser ini tidak dapat digunakan.
               Upgrade ke <a href="//www.google.com/chrome">Chrome</a>
             version 25 atau diatasnya.</p>
           </div>
           <div class="right">
            <button id="start_button" onclick="startButton(event)">
              <img id="start_img" src="/icon-speech/mic.gif" alt="Start"></button>
            </div>
            <div id="results">
              <span id="final_span" class="final"></span>
              <span id="interim_span" class="interim"></span>
              <p>
              </div>
              <div class="center">
                <div class="sidebyside" style="text-align:right">
                  <button id="copy_button" class="button" onclick="copyButton()">
                  Copy and Paste</button>
                  <div id="copy_info" class="info">
                    Tekan Ctrl+C untuk copy tet.
                  </div>
                </div>
                <p>
                  <div id="div_language" style="display: none;">
                    <select id="select_language" onchange="updateCountry()"></select>
                    &nbsp;&nbsp;
                    <select id="select_dialect"></select>
                  </div>
                </div>
              </div>
            </div>
              <!-- Mainly scripts -->
              <script src="/assets/js/bootstrap.min.js"></script>

              <!-- Sweet alert -->
              <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
              <script>
                var langs =
                [['Bahasa Indonesia',['id-ID']],
                ];

                for (var i = 0; i < langs.length; i++) {
                  select_language.options[i] = new Option(langs[i][0], i);
                }
                select_language.selectedIndex = 0;
                updateCountry();
                select_dialect.selectedIndex = 0;
                showInfo('info_start');

                function updateCountry() {
                  for (var i = select_dialect.options.length - 1; i >= 0; i--) {
                    select_dialect.remove(i);
                  }
                  var list = langs[select_language.selectedIndex];
                  for (var i = 1; i < list.length; i++) {
                    select_dialect.options.add(new Option(list[i][1], list[i][0]));
                  }
                  select_dialect.style.visibility = list[1].length == 1 ? 'hidden' : 'visible';
                }

                var create_email = false;
                var final_transcript = '';
                var recognizing = false;
                var ignore_onend;
                var start_timestamp;
                if (!('webkitSpeechRecognition' in window)) {
                  upgrade();
                } else {
                  start_button.style.display = 'inline-block';
                  var recognition = new webkitSpeechRecognition();
                  recognition.continuous = true;
                  recognition.interimResults = true;

                  recognition.onstart = function() {
                    recognizing = true;
                    showInfo('info_speak_now');
                    start_img.src = '/icon-speech/mic-animate.gif';
                  };

                  recognition.onerror = function(event) {
                    if (event.error == 'no-speech') {
                      start_img.src = '/icon-speech/mic.gif';
                      showInfo('info_no_speech');
                      ignore_onend = true;
                    }
                    if (event.error == 'audio-capture') {
                      start_img.src = '/icon-speech/mic.gif';
                      showInfo('info_no_microphone');
                      ignore_onend = true;
                    }
                    if (event.error == 'not-allowed') {
                      if (event.timeStamp - start_timestamp < 100) {
                        showInfo('info_blocked');
                      } else {
                        showInfo('info_denied');
                      }
                      ignore_onend = true;
                    }
                  };

                  recognition.onend = function() {
                    recognizing = false;
                    if (ignore_onend) {
                      return;
                    }
                    start_img.src = '/icon-speech/mic.gif';
                    if (!final_transcript) {
                      showInfo('info_start');
                      return;
                    }
                    showInfo('');
                    if (window.getSelection) {
                      window.getSelection().removeAllRanges();
                      var range = document.createRange();
                      range.selectNode(document.getElementById('final_span'));
                      window.getSelection().addRange(range);
                    }
                    if (create_email) {
                      create_email = false;
                      createEmail();
                    }
                  };

                  recognition.onresult = function(event) {
                    var interim_transcript = '';
                    for (var i = event.resultIndex; i < event.results.length; ++i) {
                      if (event.results[i].isFinal) {
                        final_transcript += event.results[i][0].transcript;
                      } else {
                        interim_transcript += event.results[i][0].transcript;
                      }
                    }
                    final_transcript = capitalize(final_transcript);
                    final_span.innerHTML = linebreak(final_transcript);
                    interim_span.innerHTML = linebreak(interim_transcript);
                    if (final_transcript || interim_transcript) {
                      showButtons('inline-block');
                    }
                  };
                }

                function upgrade() {
                  start_button.style.visibility = 'hidden';
                  showInfo('info_upgrade');
                }

                var two_line = /\n\n/g;
                var one_line = /\n/g;
                function linebreak(s) {
                  return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
                }

                var first_char = /\S/;
                function capitalize(s) {
                  return s.replace(first_char, function(m) { return m.toUpperCase(); });
                }

                function createEmail() {
                  var n = final_transcript.indexOf('\n');
                  if (n < 0 || n >= 80) {
                    n = 40 + final_transcript.substring(40).indexOf(' ');
                  }
                  var subject = encodeURI(final_transcript.substring(0, n));
                  var body = encodeURI(final_transcript.substring(n + 1));
                  window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
                }

                function copyButton() {
                  if (recognizing) {
                    recognizing = false;
                    recognition.stop();
                  }
                  copy_button.style.display = 'none';
                  copy_info.style.display = 'inline-block';
                  showInfo('');
                }

                function emailButton() {
                  if (recognizing) {
                    create_email = true;
                    recognizing = false;
                    recognition.stop();
                  } else {
                    createEmail();
                  }
                  email_button.style.display = 'none';
                  email_info.style.display = 'inline-block';
                  showInfo('');
                }

                function startButton(event) {
                  if (recognizing) {
                    recognition.stop();
                    return;
                  }
                  final_transcript = '';
                  recognition.lang = select_dialect.value;
                  recognition.start();
                  ignore_onend = false;
                  final_span.innerHTML = '';
                  interim_span.innerHTML = '';
                  start_img.src = '/icon-speech/mic-slash.gif';
                  showInfo('info_allow');
                  showButtons('none');
                  start_timestamp = event.timeStamp;
                }

                function showInfo(s) {
                  if (s) {
                    for (var child = info.firstChild; child; child = child.nextSibling) {
                      if (child.style) {
                        child.style.display = child.id == s ? 'inline' : 'none';
                      }
                    }
                    info.style.visibility = 'visible';
                  } else {
                    info.style.visibility = 'hidden';
                  }
                }

                var current_style;
                function showButtons(style) {
                  if (style == current_style) {
                    return;
                  }
                  current_style = style;
                  copy_button.style.display = style;
                  email_button.style.display = style;
                  copy_info.style.display = 'none';
                  email_info.style.display = 'none';
                }
              </script>

            </body>
            </html>