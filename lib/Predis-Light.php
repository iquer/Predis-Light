<?php
class Predis_ClientException extends Exception { }
class Predis_Client {
const NEWLINE = "\r\n";
const OK = 'OK';
const NULL = 'nil';
const CONNECTION_TIMEOUT = 2;
private $_socket;
public function __construct($params = array()) {
if (count($params)>1)
$this->connect($params);
}
public function __destruct() {
$this->disconnect();
}
public function connect($params) {
$uri = sprintf('tcp://%s:%d/', $params['host'], $params['port']);
$connectionTimeout = isset($this->_params->connection_timeout)  ? $this->_params->connection_timeout
: self::CONNECTION_TIMEOUT;
$this->_socket = @stream_socket_client($uri, $errno, $errstr, $connectionTimeout);
if (!$this->_socket) {
throw new Predis_ClientException(trim($errstr), $errno);
}
}
 public function disconnect() {
if (is_resource($this->_socket))
fclose($this->_socket);
}
private function write($data) {
if (!fwrite($this->_socket, $data))  throw new Predis_ClientException(sprintf(
'An error has occurred while writing data %s on the network stream'),
$data
);
}
private function read() {
$header = fgets($this->_socket);
if ($header === false) {
throw new Predis_ClientException('An error has occurred while reading from the network stream');
}
$prefix = $header[0];
$payload = substr($header, 1, -2);
switch($prefix) {
case '+':  return ($payload == self::OK ? true : $payload);
break;
case '$':  if (!is_numeric($payload)) {
throw new Predis_ClientException("Cannot parse '$dataLength' as data length");
}
if ($payload > 0) {
$value = stream_get_contents($this->_socket, $payload);
if ($value === false) {
throw new Predis_ClientException('An error has occurred while reading from the network stream');
}
fread($this->_socket, 2);
return $value;
}
else if ($dataLength == 0) {
fread($this->socket, 2);
return '';
}
return null;
break;
case ':':  if (is_numeric($payload)) {
return (int) $payload;
}
else {
if ($payload !== self::NULL) {
throw new Predis_ClientException("Cannot parse '$number' as numeric response");
}
return null;
}
break;
case '-':  throw new Predis_ClientException(substr($payload, 4));
break;
default:
if (!isset($this->$_prefixHandlers[$prefix]))
throw new Predis_ClientException("Unknown prefix '$prefix'");
break;
}
}
public function auth($pass) {
echo $this->write('AUTH ' . $pass . self::NEWLINE);
return $this->read();
}
public function select($db) {
$this->write('SELECT ' . $db . self::NEWLINE);
return $this->read();
}
public function get($key) {
$this->write('GET ' . $key . self::NEWLINE);
return $this->read();
}
public function set($key,$value) {
$this->write('SET ' . $key . ' '.strlen($value) . self::NEWLINE . $value . self::NEWLINE);
return $this->read();
}
public function delete($key) {
$this->write('DEL ' . $key . self::NEWLINE);
return $this->read();
}
public function incr($key) {
$this->write('INCR ' . $key . self::NEWLINE);
return $this->read();
}
public function decr($key) {
$this->write('DECR ' . $key . self::NEWLINE);
return $this->read();
}
public function exists($key) {
$this->write('EXISTS ' . $key . self::NEWLINE);
return $this->read();
}
public function expire($key,$value) {
$this->write('EXPIRE ' . $key . ' ' . $value . self::NEWLINE);
return $this->read();
}
public function ttl($key) {
$this->write('ttl ' . $key . self::NEWLINE);
return $this->read();
}
}
?>
