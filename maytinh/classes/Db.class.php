<?php
class Db{
    private $_numRow;
    private $dbh= null;

    public function __construct()
    {
        $driver="mysql:host=". HOST."; dbname=". DB_NAME;
        try
        {
            // --- BẮT ĐẦU SỬA ---

            // 1. Tạo mảng tùy chọn để yêu cầu kết nối an toàn (SSL)
            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/DigiCertGlobalRootG2.crt.pem'
            );

            // 2. Thêm biến $options vào cuối lệnh tạo kết nối
            $this->dbh = new PDO($driver, DB_USER, DB_PASS, $options);

            // --- KẾT THÚC SỬA ---
            
            $this->dbh->query("set names 'utf8' ");
        }
        catch(PDOException $e)
        {
            echo "Err:". $e->getMessage(); exit();
        }
    }

    public function __destruct()
    {
        $this->dbh= null;
    }

    public function getRowCount()
    {
        return $this->_numRow;
    }

    private function query($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
    {
        $stm = $this->dbh->prepare($sql);
        if (!$stm->execute( $arr))
        {
            echo "Sql lỗi."; exit;
        }
        $this->_numRow = $stm->rowCount();
        return $stm->fetchAll($mode);
    }

    /*
    Sử dụng cho các sql select
    */
    public function exeQuery($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC)
    {
        return $this->query($sql, $arr, $mode);
    }

    /*
    Sử dụng cho các sql cập nhật dữ liệu. Kết quả trả về số dòng bị tác động
    */
    public function exeNoneQuery($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC)
    {
        $this->query($sql, $arr, $mode);
        return $this->getRowCount();
    }

    /* su dung de dem so phan tu cua table ...*/
    public function countItems($sql, $arr= array())
    {
        $data = $this->exeQuery($sql, $arr, PDO::FETCH_BOTH);
        return $data[0][0];
    }
}
?>
