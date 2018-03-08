# kasparsu/prettyxml

Xml prettifier that uses no libs or packages

## Installation

You can add this library as a local, per-project dependency to your project using [Composer](https://getcomposer.org/):

    composer require kasparsuu/prettyxml

If you only need this library during development, for instance to run your project's test suite, then you should add it as a development-time dependency:

    composer require --dev kasparsuu/prettyxml

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