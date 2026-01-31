<?php
// actions.php
header('Content-Type: application/json; charset=utf-8');
$fn = __DIR__ . '/cases.json';
$action = $_GET['action'] ?? ($_POST['action'] ?? 'list');

function read_data($fn){
    if(!file_exists($fn)){
        file_put_contents($fn, json_encode([]));
    }
    $json = file_get_contents($fn);
    $arr = json_decode($json, true);
    return is_array($arr) ? $arr : [];
}

function write_data($fn, $arr){
    $tmp = $fn . '.tmp';
    $f = fopen($tmp, 'w');
    if($f === false) return false;
    if(flock($f, LOCK_EX)){
        fwrite($f, json_encode($arr, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        fflush($f);
        flock($f, LOCK_UN);
    }
    fclose($f);
    rename($tmp, $fn);
    return true;
}

if($action === 'list'){
    echo json_encode(read_data($fn));
    exit;
}

if($action === 'get'){
    $id = $_GET['id'] ?? '';
    $arr = read_data($fn);
    foreach($arr as $c) if($c['id'] === $id){ echo json_encode($c); exit; }
    echo json_encode(null); exit;
}

if($action === 'add'){
    $body = json_decode(file_get_contents('php://input'), true);
    if(!is_array($body)){ echo json_encode(['success'=>false,'msg'=>'Invalid']); exit; }
    $arr = read_data($fn);
    $id = 'CS-'.strtoupper(substr(uniqid(),0,8));
    $new = [
        'id'=>$id,
        'title'=>$body['title'] ?? 'Untitled',
        'type'=>$body['type'] ?? 'Unknown',
        'lead'=>$body['lead'] ?? '',
        'status'=>$body['status'] ?? 'Open',
        'desc'=>$body['desc'] ?? '',
        'evidence'=>$body['evidence'] ?? '',
        'date'=>date('Y-m-d')
    ];
    array_unshift($arr, $new);
    $ok = write_data($fn, $arr);
    echo json_encode(['success'=> (bool)$ok, 'id'=>$id]);
    exit;
}

if($action === 'delete'){
    $id = $_GET['id'] ?? '';
    $arr = read_data($fn);
    $newarr = array_values(array_filter($arr, function($c) use($id){ return $c['id'] !== $id; }));
    $ok = write_data($fn, $newarr);
    echo json_encode(['success'=> (bool)$ok]);
    exit;
}

echo json_encode(['success'=>false,'msg'=>'unknown action']);
