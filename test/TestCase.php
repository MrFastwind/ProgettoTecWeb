<?php
namespace test{
    use ReflectionClass;
    use ReflectionMethod;
    use Exception;

    abstract class TestCase{

        function __construct(){
            $this->runTests();
        }

        public function beforeAll(){
        }
        public function beforeEach(){

        }
        public function afterEach(){

        }
        public function afterAll(){
        }

        public function runTests(){
            $this->beforeAll();
            $methods=$this->getTests();
            $cclass = $this::class;
            echo nl2br("Test Class: ".$cclass."\n");
            foreach($methods as $key=>$method){
                try{
                $this->beforeEach();
                }catch(Exception $e){
                    $class=$e::class;
                    $message=$e->getMessage();
                    $trace = ($e->getTraceAsString());
                    echo nl2br(<<<Textarea
                    # BeforeEach:Failed

                    $class: $message
                    $trace
                    Textarea);
                }
                try{
                    $it=
                    $it=$method->name;
                    $method->invoke($this);
                    echo nl2br("## $it:OK<BR>");
                }catch(Exception $e){
                    $class=$e::class;
                    $message=$e->getMessage();
                    $trace = ($e->getTraceAsString());
                    echo nl2br(<<<Textarea
                    ## $it:Failed

                    $class: $message
                    $trace
                    Textarea);
                }
                $this->afterEach();
            }
            $this->afterAll();
            echo"<BR><BR>";
        }
        
        /**
         * getTests
         *
         * @return ReflectionMethod[]
         */
        private function getTests():array{
            $methods_to_call=[];
            $class = new ReflectionClass($this::class);
            $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
            foreach($methods as $key=>$method){
                if(!in_array($method->name,["__construct","beforeAll","beforeEach","runTests","afterEach","afterAll"])){
                    $methods_to_call[]=$method;
                }
            }
            return $methods_to_call;
        }

    }
}
?>