<?php
function send_wol($mac) {
    // Verwijder ':' en '-' uit het MAC-adres
    $mac_bytes = pack('H*', str_replace([':', '-'], '', $mac));
    $packet = str_repeat(chr(0xFF), 6) . str_repeat($mac_bytes, 16);

    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, true);

    // Pas dit aan op basis van je subnet, bijvoorbeeld 192.168.178.255
    socket_sendto($sock, $packet, strlen($packet), 0, '192.168.178.255', 9);
    socket_close($sock);
}

$wol_sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $mac_address = '00:00:00:00:00:00'; //change this to the MAC address of the target PC
    send_wol($mac_address);
    $wol_sent = true;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wake On LAN Controller</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #1f4037, #99f2c8);
            color: #333;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        h1 {
            margin-bottom: 30px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .message {
            margin-top: 20px;
            color: #155724;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Start PC via Wake-on-LAN</h1>
    <form method="post">
        <button type="submit">Start PC</button>
    </form>
    <?php if ($wol_sent): ?>
        <div class="message">✅ Wake-on-LAN signaal verzonden!</div>
    <?php endif; ?>
</div>
</body>
</html>
