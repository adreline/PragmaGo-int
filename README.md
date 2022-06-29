### What is this repository for? ###

This is a coding job interview solution. "Write a program which is adding name property into each leaf of given tree structure from ​tree.json​ file with name from ​list.json​ file. ​category_id​ from ​list.json​ and ​Id ​in ​tree.json are corelated​".

### Setup ###

Pull the repo

```bash
git clone https://github.com/adreline/PragmaGo-int.git
```

Verify that you have php version >7 installed

```bash
php -v
PHP 7.4.3
```

### Usage ###

Test the code aganist an example data

```bash
php main.php -t example_data/tree.json -l example_data/list.json
```

Outputs

```bash
written 2081 bytes to pragmaout_62bc716724a6a.json
```

### Options ###

```
-t
    Required. Specify a path to a input tree file in a json format.
-l
    Required. Specify a path to a input list file in a json format, containing references to category name id's.
--dry
    Do not write out any data. Results will be printed on console.
-o
    Output path. If not specified, a auto generated file name for the output will be choosen.
```