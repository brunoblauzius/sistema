Captcha-PHP
===========

Código fonte para geração de códigos de segurança (Captcha)

Descrição das Pastas

- fonts: Arquivos de fontes para criação do captcha *.ttf
- audio: Arquivos *.wav para criação do audio
- lib: Classe do Captcha
- controller: Classe de controle do captcha

Descrição dos métodos da classe Captcha Controller

- displayAction: Exibir o Código de Segurança gerado
- audioPlayAction: Executar o arquivo de audio
- getValue: Pegar o valor do captcha na sessão
- destroy: Destruir a sessão do captcha
