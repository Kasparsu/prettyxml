# kasparsu/prettyxml

Xml prettifier that uses no libs or packages. 

####DISCLAIMER: This is in development and if you have any sense or reason you will not use this package!

## Installation

You can add this library as a local, per-project dependency to your project using [Composer](https://getcomposer.org/):

    composer require kasparsu/prettyxml

If you only need this library during development, for instance to run your project's test suite, then you should add it as a development-time dependency:

    composer require --dev kasparsu/prettyxml

### Usage

#### Prettyfing Xml

The `Prettyfier` class can be used to generate a formated representation of the raw XML input:

```php
<?php
$pretty = new \Kasparsu\PrettyXml\Prettyfier('<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', "\t");
print $pretty->prettify();
```

The code above yields the output below:
```xml
<apply>
       <csymbol encoding="OpenMath">
           <msub>
               <mi>P</mi>
               <mn>1</mn>
           </msub>
       </csymbol>
       <ci>x</ci>
</apply>
```

### Development

You can run docker enviroment using

    docker-compose up -d
    
to run tests use 

    docker-compose exec app vendor/bin/phpunit
    
to run examples 

    docker-compose exec app php example/example.php
    
    docker-compose exec app php example/example3mb.php
    
    docker-compose exec app php example/example200kb.php