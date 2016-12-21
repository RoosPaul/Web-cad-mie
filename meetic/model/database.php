    <?php

    class database {
        protected $bdd;
        public function __construct()
        {
            try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=meetic;
            charset=utf8',
            'root', '8wgjlndx');
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }