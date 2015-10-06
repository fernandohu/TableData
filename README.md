# TableData
Use this project if you need to display data in HTML table format.

## Features
* HTML conformant: it uses THEAD, TH, TBODY, TR, TD to build the table.
* Column ordering: a little icon (arrow down and arrow up) can be displayed in the columns headers and a link is created with the url schema provided.
* Column size: columns sizes can be set with a value. Use "*" to make it expand to the visible area.
* Cell filter: a filter function can be used to change data before displaying it.
* Built-in filters:
  * Check: display a checkbox
  * CheckAll: display a check all box in the header
  * Status: display a green/red rectangle representing active/inactive


## Example

First step is to set the headers, column sizes and enable column ordering.

```php
$grid = new Table(new Builtin());
$grid->setHeaderLink('index?row=%ROW_ID%&direction=%DIRECTION%');
$grid->setHeader([
    'check'           => false,
    'category_id'     => 'Id',
    'dsc_name'        => 'Nome da categoria',
    'dsc_description' => 'Descrição',
    'bit_active'      => 'Ativo',
]);
$grid->setColumnSizes(['60', '60', '*', '5']);
$grid->enableOrdering([false, true, true, true]);
$grid->setOrderingColumn('dsc_name');
$grid->setOrder(Table::DIRECTION_DOWN);

$grid->setData($data);
```
You may set the $data variable with something like:
```php
$data = array (
  [false, '1', 'Alimentação (Restaurantes)', '1'],
  [false, '2', 'Alimentos (produtos)', '1'],
  [false, '3', 'Assistência técnica', '1'],
  [false, '4', 'Bancos e Financeiras', '1'],
  [false, '5', 'Bares e casas noturnas', '1'],
  [false, '6', 'Bebidas', '1'],
  [false, '7', 'Brinquedos', '1'],
  [false, '9', 'Buffet, Decorações e Casamento', '1'],
  [false, '10', 'Carros, Motos e Acessórios', '1'],
  [false, '11', 'Cartões de Crédito', '1'],
  [false, '12', 'Cartórios', '1'],
  [false, '13', 'Casa - Construção, Decoração, Móveis e Administração', '1'],
  [false, '14', 'Cemitérios/Prestadoras de serviço', '1'],
  [false, '15', 'Cigarros', '1'],
  [false, '16', 'Clube de compras online', '1'],
  [false, '17', 'Colchões', '1'],
  [false, '18', 'Companhias Aéreas', '1'],
  [false, '19', 'Compras coletivas', '1'],
  [false, '20', 'Concessionárias', '1'],
  [false, '21', 'Conselhos', '1'],
);
```
Filters may be configured with this:
```php
 $check = new Check();
 $checkAll = new CheckAll();
 $status = new Status();
 
 $grid->setFilter('check', false, array($check, 'apply'));
 $grid->setFilter('check', true, array($checkAll, 'apply'));
 $grid->setFilter('bit_active', false, array($status, 'apply'));
```
Last step is call the render method:
```php
echo $grid->render();
```
Assuming you have Twitter Bootstrap installed, the result should be something like this:
![](https://github.com/fernandohu/TableData/blob/master/documentation/image01.png)
