<?php
$tip =  $_POST['tip'];

//filtriranje
//validacija

if ($tip == 'polaznici') {
    $html = "
    <h1>Polaznici</h1>
    <ul>
        <li>Nesa</li>
        <li>Andrej</li>
        <li>Luka</li>
        <li>Aleksa</li>
        <li>Dejan</li>
    </ul>
    ";
}


$proizvodi = ['keks', 'kikiriki', 'smoki'];
if ($tip == 'proizvodi') {
    $html = "";
    if (count($proizvodi) > 0) {
        $html .= "
        <h1>Proizvodi</h1>
        <table>
            <thead>
                <tr>
                    <th>Proizvod</th>
                </tr>
            </thead>
            <tbody>
        ";
        foreach ($proizvodi as $value) {
            $html .= "
            <tr>
                <td>$value</td>
            </tr>
            ";
        }
    }
    $html .= "
        </tbody>
    </table>    
    ";
}

echo $html;
