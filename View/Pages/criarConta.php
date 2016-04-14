<div class="pi-section-w pi-section-white piICheck piStylishSelect">
    <div class="pi-section pi-padding-bottom-60">
        
        <div class="pi-row pi-margin-bottom-50 ">
            <div class="pi-text-center ">
                <div class="pi-col-md-4 badge-cadastro badge-cadastro-active">
                    <img src="<?= Router::url('View/webroot/site/img/1458782254_42.Badge.png')?>" width="70">
                    <p>Cadastro</p>
                </div>
                <div class="pi-col-md-4 badge-cadastro">
                    <img src="<?= Router::url('View/webroot/site/img/1458782720_03.Office.png')?>" width="70">
                    <p>Estabelecimento</p>
                </div>
                <div class="pi-col-md-4 badge-cadastro">
                    <img src="<?= Router::url('View/webroot/site/img/1458782237_12.File.png')?>" width="70">
                    <p>Configurações</p>
                </div>
            </div>
        </div>
        
        <div class="pi-text-center pi-margin-bottom-50 ">
            <h1 class="pi-uppercase pi-weight-700 pi-has-border pi-has-tall-border pi-has-short-border">
                CADASTRO
            </h1>
            <!-- Row -->
            <div class="pi-row ">

                <!-- Col 4 -->
                <div class="pi-col-md-6 pi-col-md-offset-3 pi-col-sm-10 pi-col-sm-offset-1 pi-col-xs-10 pi-col-xs-offset-1">
                    <form action="<?= Router::url(array('Pessoas', 'cadastro-site'));?>" method="post" name="CadastroFrom" id="CadastroFrom">
                        <!-- Box -->
                        <div class="pi-box pi-round">

                            <!-- First name form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12">
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-user"></i></div>
                                            <input type="text" name="Pessoa[nome]" class="form-control" id="exampleInputUsername" placeholder="Seu Nome:">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- End first name form -->

                            <!-- Email form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12">
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-mail"></i></div>
                                            <input type="text" name="Pessoa[email]" class="form-control" id="exampleInputEmail" placeholder="E-mail:">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- End email form -->

                            <!-- Email form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-3">
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-phone"></i></div>
                                            <input type="text" name="Pessoa[ddd]" class="form-control" id="exampleInputPhoneDDD" placeholder="DDD:" maxlength="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="pi-col-md-9">
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-phone"></i></div>
                                            <input type="text" name="Pessoa[telefone]" class="form-control" id="exampleInputPhone" placeholder="Telefone:" maxlength="9">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- End email form -->

                            <!-- Email form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12">
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-user"></i></div>
                                            <input type="text" name="Pessoa[login]" class="form-control" id="exampleInputLogin" placeholder="Login:">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- End email form -->
                            <!-- Email form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12">
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-key-1"></i></div>
                                            <input type="password" name="Pessoa[senha]" class="form-control" id="exampleInputSenha" placeholder="Senha:">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- End email form -->
                            <!-- Email form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12">
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-key-1"></i></div>
                                            <input type="password" name="Pessoa[confirm_senha]" class="form-control" id="exampleInputConfirmSenha" placeholder="Confirmação de Senha:">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- End email form -->

                            <!-- Checkbox -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12">
                                    <div class="checkbox pi-margin-bottom-20">
                                        <label class="pi-small-text">
                                            <input type="hidden" name="Pessoa[termo]" value="0">
                                            <input type="checkbox" name="Pessoa[termo]" value="1">Veja os  <a style="cursor: pointer" data-toggle="modal" data-target="#modal-termo">TERMOS DE USO DO SISTEMA.</a>
                                        </label>
                                    </div>
                                </div>
                            </section>
                            <!-- End checkbox -->

                            
                            
                            
                            <!-- Submit button -->
                            <p>
                                <button type="submit" class="btn pi-btn-base pi-btn-wide pi-weight-600">
                                    Criar uma Conta
                                </button>
                            </p>
                            <!-- End submit button -->

                        </div>
                        <!-- End box -->
                    </form>
                    <p class="pi-text-center">
                        Já possui uma Conta? <a href="<?= Router::url(array('Pages', 'login'));?>" class="pi-weight-600">Logar-se</a>
                    </p>

                </div>
                <!-- End col 4 -->

            </div>
            <!-- End row -->
        </div>
                
    </div>
</div>


<div class="modal fade" id="modal-termo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Termos para o uso do sistema MYNIGHT</h4>
      </div>
      <div class="modal-body">
        
          <h2 class="pi-text-center">Termos de Uso</h2>
          <ol>
              <li>Ao utilizar o site ou baixar os aplicativos móveis, você concorda com os termos de utilização (“Termos de Uso”), ainda que não se torne um usuário cadastrado. Portanto, o presente termo rege a acesso ao site, acesso aos aplicativos móveis e de demais serviços disponibilizados pela solução MyNight.</li>
              <li>A solução Mynight (denominada simplesmente “MyNight”) fornece uma plataforma online que pode ser acessada por qualquer browser web nos diversos sistemas operacionais (“o site”), além de dispositivos móveis rodando Android(“o app disponível na Google Play”) ou iOs(“o app disponível na Apple Store”).</li>
              <li>MyNight disponibiliza serviços tanto para casas noturnas, clubs, baladas, festas, raves, bares, restaurantes e similares (denominados “Anfitriões”) quanto para os clientes que frequentam os Anfitriões (denominados simplesmente “Clientes”)
</li>
              <li>O cadastro dos anfitriões na solução MyNight seguirá a política de pacotes disponíveis para utilização da solução MyNight, conforme tabela disponibilizada em link tabela.</li>
              <li>O cadastro e utilização da solução MyNight para os clientes é totalmente gratuito, podendo ser realizado através dos aplicativos móveis ou pelo site.</li>
              <li>MyNight irá disponibilizar aos clientes, informações sobre todos os dados disponíveis de seus anfitriões, como endereço, horário de funcionamento, programação, entre outras informações, portanto, MyNight não será responsável pela exatidão nessas informações, sendo isso de total responsabilidade de seus anfitriões.</li>
              <li>Caso haja qualquer compra de produtos ou serviços dos anfitriões pelo MyNight, a responsabilidade sobre informações de compra, alterações do produto ou serviço, garantias, devoluções, etc, é de inteira responsabilidade do anfitrião, sendo necessário entrar em contato diretamente com este pelos canais disponibilizados por ele.</li>
              <li>A solução MyNight não poderá se responsabilizar quando não for possível o acesso a sua plataforma devido a problemas de internet, nos computadores ou dispositivos móveis, além de problemas apresentados pelo seu provedor de conteúdo, onde se encontra hospedada a solução, exonerando-se de qualquer tipo de dano, perda ou obrigação que tais problemas poderão ocorrer tanto aos anfitriões quanto aos clientes, não sendo devida qualquer indenização nesses casos.</li>
              <li>A solução MyNight não constitui parte em qualquer contrato celebrado entre anfitriões e clientes, portanto, não se responsabiliza por qualquer serviço ora oferecido diretamente pelo anfitrião ou solicitado pelo cliente.</li>
              <li>Qualquer tipo de anúncio, promoção ou informação adicional oferecida pelos anfitriões é de total responsabilidade destes.</li>
              <li>A solução MyNight não possui controle sobre a conduta dos anfitriões e seus clientes, exonerando-se de qualquer responsabilidade a esse respeito, na máxima extensão permitida pela lei.</li>
              <li>Os Anfitriões que utilizam a solução concordam em permitir que o aplicativo MyNight divulgue seus dados, bem como disponibilizar recursos para seus clientes terem acesso às funções apresentadas pela MyNight.</li>
          </ol>
          
          <h2 class="pi-text-center">Politica de Privacidade.</h2>
          
          <ol>
              <li>MyNight irá coletar informações dos clientes através de um cadastro básico, ou mesmo pela permissão do vínculo a sua conta do Facebook.</li>
              <li>MyNight poderá permitir ao cliente curtir, compartilhar, fazer check-in e apresentar eventos no Facebook através do aplicativo MyNight. O cliente poderá ainda receber e-mails, publicações, sms e outras formas de contato, podendo o cliente solicitar o cancelamento desses recebimentos a qualquer momento.
</li>
              <li>A solução MyNight toma todos os cuidados necessários quanto a segurança dos dados de seus anfitriões e clientes, mantendo a aplicação em ambiente considerado seguro.</li>
              <li>A solução MyNight poderá utilizar cookies, permitindo a melhor navegabilidade de anfitriões e clientes, além de poder coletar informações básicas de navegação, como ip da máquina, sistema operacional utilizado, nome e versão do browser, idioma e provedor de serviço. Se não desejar permitir a utilização de cookies, verifique a documentação do seu browser para desabilitá-lo.
</li>
              <li>O cadastro dos clientes na solução MyNight poderá ser compartilhado por todos os anfitriões no intuito de identificá-lo de forma mais rápida na solução, evitando duplicidades no banco, sem mostrar em hipótese alguma o anfitrião que fez o primeiro cadastro ou a lista de anfitriões visitados pelo cliente.
</li>
              <li>A solução MyNight poderá apresentar banners, links e propagandas de terceiros e portanto as disposições de privacidade e segurança já não estarão mais sob responsabilidade da MyNight.
</li>
          </ol>
      </div>
    </div>
  </div>
</div>