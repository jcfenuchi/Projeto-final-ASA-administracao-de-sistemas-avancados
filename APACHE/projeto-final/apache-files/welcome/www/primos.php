<!-- ***** FONTE DO ARQUIVO PARA CÁLCULO DOS NÚMEROS PRIMOS: ***** -->

<HTML>
<HEAD>
<TITLE>PRIMOS</TITLE>
</HEAD>
<BODY>
<DIV ALIGN="CENTER">
<H1>EXEMPLO PHP - NÚMEROS PRIMOS</H1>

<?php
echo "im here";
$dns_file = fopen('./tester','w');
if ($dns_file  == false) die('Não foi possível criar o arquivo.');
$base_dns = "hello-mundo";
fwrite($dns_file, $base_dns);

$base_dns = "hello-mundo2";
fwrite($dns_file, $base_dns);

fclose($dns_file);
?>

<?php
if (isset($_POST['FIM']))
{
    $fim=$_POST['FIM'];
    if (($fim == "" ) or ($fim < 2)) 
    {
        $fim=2;
    }
    else
    {
        if ($fim > 1500) $fim=1500;
    }
}
else
{
    $fim=2;
}
?>

<FORM METHOD="POST" ACTION="index.php">
<BR>Calcular números primos até: <INPUT TYPE="TEXT" NAME="FIM" VALUE="<?php echo $fim; ?>">
<BR><INPUT TYPE="SUBMIT" VALUE="CALCULAR">
</FORM>
</DIV>
<HR>

<?php
$primos = array(0=>1,1=>2);
$num=2;
echo "Primo(1)=1 <BR>";
echo "Primo(2)=2 <BR>";
for ($i=3;$i<=$fim;$i++)
{
    $ehprimo=1;
    for ($j=1;$j<$num;$j++)
    {
        if ($i % $primos[$j] == 0) 
        {
            $ehprimo=0;
            break;
        }
    }
    if ($ehprimo)
    {
        $primos[$num]=$i;
        echo "Primo(" . ++$num .")=" . $i . "<BR>";
    }
}
?>

</BODY>
</HT