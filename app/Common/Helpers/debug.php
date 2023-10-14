<?php 


//use Illuminate\Support\Debug\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;


/*use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;*/



if(! function_exists('dump2')){
    function dump2()
    {
        $args = func_get_args();
        $defaultStringLength = -1;
        $defaultItemNumber = -1;
        $defaultDepth = -1;

        foreach ($args as $variable) {
            $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

            $cloner = new VarCloner();
            $cloner->setMaxString($defaultStringLength);
            $cloner->setMaxItems($defaultItemNumber);

            $dumper->dump($cloner->cloneVar($variable)->withMaxDepth($defaultDepth));
        }

        //die(1);
    }
}



if(! function_exists('dd2')){
    function dd2()
    {
        $args = func_get_args();
        $defaultStringLength = -1;
        $defaultItemNumber = -1;
        $defaultDepth = -1;

        foreach ($args as $variable) {
            $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

            $cloner = new VarCloner();
            $cloner->setMaxString($defaultStringLength);
            $cloner->setMaxItems($defaultItemNumber);

            $dumper->dump($cloner->cloneVar($variable)->withMaxDepth($defaultDepth));
        }

        die(1);
    }
}




if(! function_exists('print_array')){
    function print_array($arg)
    {        
        echo "||---------------------------------||<br/>";
        echo "<pre>";
        print_r($arg); 
        echo "</pre>";
        echo "END <br/>"."||---------------------------------||<br/>";
        //die(1);
    }
}




