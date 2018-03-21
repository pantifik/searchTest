<?php
class FileReader
{
  protected $handler = null;
  protected $fbuffer = array();

  public function __construct($filename)
  {
    if(!($this->handler = fopen($filename, "rb")))
      throw new Exception("Cannot open the file");
  }

  public function Read($count_line = 10)
  {
    if(feof($this->handler)){
      return false;
    }
    $this->fbuffer = array();
    if(!$this->handler)
      throw new Exception("Invalid file pointer");

    while(!feof($this->handler))
    {
      $this->fbuffer[] = fgets($this->handler);
      $count_line--;
      if($count_line == 0) break;
    }

    return $this->fbuffer;
  }

  public function SetOffset($line = 0)
  {
    rewind($this->handler);
    if(!$this->handler)
      throw new Exception("Invalid file pointer");

    while(!feof($this->handler) && $line--) {
      fgets($this->handler);
    }
  }
}



function runSearch($fileName, $n){
  $stream       = new FileReader($fileName);
  $line         = 0;
  $count_line   = 500;
  $val          = false;

  $stream->SetOffset($line);

  while (!$val){
    if(!($result = $stream->Read($count_line))) break;

    $val = search($result, $n);
  }

  if( !$val ){
    return 'undef';
  }
  return $val;
}



function search($arr, $n){

  list($id, $val) = explode("\t", end($arr));
  if(strcmp(trim($id), $n) < 0){
    return false;
  }

  $pos = floor(count($arr)/2);

  list($id, $val) = explode("\t", $arr[$pos]);

  if($pos == 0 && strcmp(trim($id), $n) != 0){
    return false;
  }

  if(strcmp(trim($id), $n) == 0){
    return $val;
  }
  elseif (strcmp(trim($id), $n) > 0) {
    return search(array_slice($arr, 0, $pos), $n);
  }
  else{
    return search(array_slice($arr, $pos), $n);
  }
}


print_r("<pre>");
print_r(runSearch('data', '000IaH4yHL'));
print_r("</pre>");
print_r("<pre>");
print_r(runSearch('data', 'hHs9rc7NOy'));
print_r("</pre>");
print_r("<pre>");
print_r(runSearch('data', 'zzzskWIQyl'));
print_r("</pre>");

