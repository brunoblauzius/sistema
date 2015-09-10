
<div class="panel">
    <div class="panel-heading">
        Permissoes de usuario
    </div>
    <div class="panel-body">
        <!--tab nav start-->
        <div class="col-md-8">
            <a href="<?= $this->urlRoot()?>Permissoes/controladora" class="btn btn-primary ">Controladoras</a>
            <a href="<?= $this->urlRoot()?>Permissoes/metodos" class="btn btn-primary ">Acoes</a>
            <a href="<?= $this->urlRoot()?>Grupos/index" class="btn btn-primary ">Grupos</a>
        </div>
        <div class="clearfix"></div>
        <!--tab nav start-->
        
        <table class="table table-striped table-hover"  id="dynamic-table">
            <thead>
                <tr>
                    <th>Controladora</th>
                    <th>Acao</th>
                    
                    <?php foreach ($grupos as $grupo) :?>
                        <th class="center"><?= $grupo->getNome()?></th>
                    <?php endforeach;?>
                        
                </tr>
            </thead>
            
            <tbody>
                
                <?php
                    $i = 0;
                    foreach ($controllerMetodos as $registro) :
                ?>
                    <tr>
                        <td><?= $registro->getName();?></td>
                        <td><?= $registro->getNameMetodo();?></td>
                        <?php foreach ($grupos as $grupo) :?>
                            <td class="center">
                                
                                <?php if( $this->verificaListaMetodo( $aclLista,$grupo->getId(), $registro->getIdMetodo(), $registro->getId() ) ): ?>
                                    <span class="btn btn-success btn-xs add-actions" data-ativo="1" data-url='<?= $this->urlRoot() . 'Permissoes/addGroupsActions'?>'  data-grupo="<?= $grupo->getId()?>" data-metodo="<?= $registro->getIdMetodo();?>" data-control="<?= $registro->getId();?>"><i class="fa fa-check"></i></span>
                                <?php else:?>
                                    <span class="btn btn-danger btn-xs add-actions" data-ativo="0" data-url='<?= $this->urlRoot() . 'Permissoes/addGroupsActions'?>'  data-grupo="<?= $grupo->getId()?>" data-metodo="<?= $registro->getIdMetodo();?>" data-control="<?= $registro->getId();?>"><i class="fa fa-times"></i></span>
                                <?php endif;?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php 
                    $i++;
                    endforeach;
                ?>
                
            </tbody>
            
        </table>
        
    </div>
    <div class="panel-footer">
        desenvolvido por sistemas SA.
    </div>
    
</div>

