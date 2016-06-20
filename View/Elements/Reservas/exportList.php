
<table style="font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">
    <thead>
        <th><h2>Lista de Convidados</h2></th>
    </thead>
    <tbody>
        
            <tr>
                <td>
                    <ol style="font-size:14px;">
                        <?php foreach ( $pessoas as $pessoa ):?>
                            <li><?= $pessoa['nome']?></li>
                        <?php endforeach;?>
                    </ol>
                </td>
            </tr>
    </tbody>
</table>


