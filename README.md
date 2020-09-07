# BadWordsPHP

BadWordsPHP is a library to censure all the badwords in differents langages.

## Installation

Download all the files in a folder that you want, and just include it to your project with this use

```bash
use BadWords\BadWordsFilter;
```

## Usage
Do not forget to install/create an autoloader before to instantiate your classe. You can download composer and use his autoloader.

```php
use BadWords\BadWordsFilter;

$filter = new BadWordsFilter();

//By default all the dictionnaries are selected (fr-FR / en-EN / es-ES etc...)
$string = "Je suis trop putain";
echo $filter->censureWords($string);

//You can select just one dictionnary
$string = "Je suis trop putain";
echo $filter->censureWords($string, 'fr-FR');

```

## Alpha
This library is actually in Alpha so i gonna add more features really soon :)

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
