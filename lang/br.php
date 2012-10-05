<?PHP

/*
	Arquivo do idioma Portugues/Brasil para o NewLife Blogging System v3
	--
	Douglas Milani
	webmaster@dugulin.com.br
	27 de fevereiro de 2004
*/

$l = array();

//
// Page <title>'s
// ---------------------------------------------------

$l['title-news']		= "Novidades";
$l['title-newuser']		= "Registrar Novo Usuário";
$l['title-usercp']		= "Painel de Controle de Usuário";
$l['title-edituser']	= "Editar Usuário";
$l['title-newblog']		= "Novo Blog";
$l['title-editblog']	= "Editar Blog";
$l['title-deleteblog']	= "Apagar Blog";
$l['title-view']		= "Visualizar Blogs";
$l['title-art-list']	= "Listar Artigos";
$l['title-art-view']	= "Visualizar Artigos";
$l['title-art-new']		= "Novo Artigo";
$l['title-art-edit']	= "Editar Artigo";
$l['title-art-delete']	= "Apagar Artigo";
$l['title-stats']		= "Estatísticas";
$l['title-login']		= "Entrar";
$l['title-logout']		= "Sair";
$l['title-memlist']		= "Membros";
$l['title-admincp']		= "Administração";
$l['title-postnews']	= "Postar Notícias";
$l['title-smiles']		= "Gerenciar Smiles";
$l['title-config']		= "Alterar Configuração";
$l['title-template']	= "Editar Template";
$l['title-profile']		= "Alterar Perfil";
$l['title-friends']		= "Amigos";
$l['title-validate']	= "Validar";
$l['title-avatars']		= "Avatars";
$l['title-banuser']		= "Banir Usuário";
$l['title-arebanned']	= "Você foi Banido!";

//
// Nav
// ---------------------------------------------------

$l['nav-home']			= "Início";
$l['nav-members']		= "Membros";
$l['nav-articles']		= "Artigos";
$l['nav-stats']			= "Estatísticas";
$l['nav-login']			= "Entrar";
$l['nav-register']		= "Novo Usuário";
$l['nav-user']			= "Painel de Controle";
$l['nav-logout']		= "Sair";
$l['nav-admin']			= "Administração";

//
// User CP Nav
// ---------------------------------------------------

$l['ucp-nav-newblog']	= "Novo Blog";
$l['ucp-nav-editblog']	= "Editar Blog";
$l['ucp-nav-view']		= "Visualizar Blogs";
$l['ucp-nav-profile']	= "Alterar Perfil";
$l['ucp-nav-avatars']	= "Gerenciar Avatars";
$l['ucp-nav-friends']	= "Lista de Amigos";
$l['ucp-nav-templates']	= "Mudar Templates";
$l['ucp-nav-usercp']	= "Painel de Controle";

//
// Admin CP Nav
// ---------------------------------------------------

$l['acp-nav-news']		= "Postar Novidades";
$l['acp-nav-editnews']	= "Editar Novidades";
$l['acp-nav-smiles']	= "Gerenciar Smiles";
$l['acp-nav-admincp']	= "Administração";
$l['acp-nav-config']	= "Configurar Site";
$l['acp-nav-outter']	= "Template Externo";
$l['acp-nav-mail']		= "Configurar e-mail";
$l['acp-nav-edit-user']	= "Editar Usuário";
$l['acp-nav-ban-user']	= "Banir Usuário";
$l['acp-nav-new-art']	= "Novo Artigo";
$l['acp-nav-edit-art']	= "Editar Artigo";

//
// Common
// ---------------------------------------------------

$l['username:']			= "Nome: ";
$l['password:']			= "Senha: ";
$l['submit']			= "Enviar";
$l['missing-field']		= "Falta Preencher: ";
$l['data-problems']		= "Ocorreram alguns erros ao processar seus dados: ";
$l['nlb-version']		= "3.0";
$l['full-copy']			= "Powered by NewLife Blogger v" . $l['nlb-version'] . " &copy; 2004 <a href=\"http://www.sevengraff.com\">Sevengraff</a>";
$l['access-public']		= "Público";
$l['access-friends']	= "Apenas para Amigos";
$l['access-private']	= "Particular";
$l['access-news']		= "Novidades";
$l['delete']			= "Apagar";
$l['update']			= "Atualizar";
$l['desc']				= "Descrição";
$l['options']			= "Opções";
$l['goodedit']			= "Este item foi atualizado com sucesso.";
$l['confirm-delete']	= "Você tem certeza que quer <b>apagar</b> este item? Esta ação <b>não pode ser desfeita</b>.";
$l['yes']				= "Sim";
$l['no']				= "Não";
$l['guest']				= "Anônimo";		// The name of guest's who post comments
$l['back']				= "Voltar";
$l['denied']			= "Você não tem permissão pra acessar esta área.<br>Acesso não permitido";

//
// Access Rights
// ---------------------------------------------------

$l['acp-access-blog']				= "Postar Blogs";
$l['acp-access-comment']			= "Postar Comentários";
$l['acp-access-av_use']				= "Usar Avatars";
$l['acp-access-av_up']				= "Enviar Avatars";
$l['acp-access-friends']			= "Manter Lista de Amigos";
$l['acp-access-tpl_change']			= "Usar templates padrões";
$l['acp-access-tpl_custom']			= "Editar código do template";
$l['acp-access-admin']				= "Administrador";

//
// Stats.php
// ---------------------------------------------------

$l['st-totals']			= "Resumo deste site:";
$l['st-recent']			= "Resumo das últimas 24 horas: ";
$l['st-totalusers']		= "Total de usuários registrados: ";
$l['st-totalblogs']		= "Total de blogs públicos: ";
$l['st-totalprivate']	= "Total de blogs particulares: ";
$l['st-totalcomments']	= "Total de comentários postados: ";
$l['st-rec-user']		= "Nosso mais novo usuário: ";
$l['st-rec-blog']		= "Último Blog: ";
$l['st-rec-comment']	= "Último Comentário: ";
$l['st-postby'] 		= "Postado por ";

//
// members.php
// ---------------------------------------------------

$l['mem-asc']			= "Ascendente";
$l['mem-desc']			= "Descendente";
$l['mem-sort-username']		= "Nome";
$l['mem-sort-blog_count']	= "Nº do Blog";
$l['mem-sort-registered']	= "Registrado";

//
// Register.php
// ---------------------------------------------------

$l['reg-pass-confirm']		= "Confirmar senha: ";
$l['reg-email']				= "Endereço de e-mail válido: ";
$l['reg-timezone']			= "Escolha seu fuso-horário: ";
$l['reg-template']			= "Escolha um template: ";
$l['reg-custom-field']		= "Campo Alternativo: (o que é isso?): ";
$l['reg-done']				= "Parabéns, você foi registrado. ";
$l['reg-checkmail']			= "Por favor, <b>cheque seu e-mail</b> para ativar sua conta.";
$l['reg-badusername']		= "Este nome já está em uso, escolha outro.";
$l['reg-badpassword']		= "Os campos de senha devem ser iguais.";
$l['reg-bademail']			= "E-mail inválido";
$l['reg-usedemail']			= "Este e-mail já foi utilizado por outro usuário";
$l['reg-badtemplatechoice']	= "O template que você escolheu não existe.";

//
// Fields
// ---------------------------------------------------

// editing profile fields
$l['field-email']			= "Endereço de e-mail válido:";
$l['field-date_format']		= 'Formato da data. Informações em <a href="http://www.php.net/date">date()</a>';
$l['field-perpage']			= "Número de blogs por página:";
$l['field-custom']			= "Campo Alternativo:";
$l['field-gender']			= "Sexo:";
$l['field-birthday']		= "Aniversário: <br><b>DEVE</b> ser no formato: <br>17 July 1984";
$l['field-bio']				= "Resumo:";

// Site config input fields
$l['cfg-validate_email']	= "Validar e-mails? (verdadeiro/falso)";
$l['cfg-lang']				= "Idioma: (arquivos de idiomas em /lang)";
$l['cfg-site_name']			= "Nome do Website: ";
$l['cfg-news_date_format']	= "Formato da Data para as novidades: ";
$l['cfg-news_per_page']		= "Quantidade de Novidades na página inicial";
$l['cfg-login_time']		= "Tempo para manter os usuários logados (dias):";
$l['cfg-art_date_view']		= "Formato da Data em Visualizar artigos:";
$l['cfg-art_date_list']		= "Formato da Data em Listando artigos:";
$l['cfg-memlist_per_page']	= "Quantidade de nomes mostrados na página de usuários:";
$l['cfg-memlist_date_format']	= "Formato da Data para página de usuários";
$l['cfg-recent_blog_num']	= "Quantidade de blogs recentes mostrados: ";
$l['cfg-recent_blog_date']	= "Formato da Data para recent blogs";
$l['cfg-default_date_format']	= "Formato da Data Padrão para novos usuários";
$l['cfg-server_timezone']	= "Fuso-horário do Servidor (+/- referente à GMT):";
$l['cfg-default_access']	= "Direitos de Acesso padrão para novos usuários (veja o readme.txt):";
$l['cfg-home_text']			= "Texto a ser colocado no lugar de %HOME% nos templates:";
$l['cfg-moods']				= "Selecionar estados:";
$l['cfg-comment_date_format']	= "Formato da Data para comentários: ";
$l['cfg-avatar_size']		= "Tamanho Máximo para avatars enviados (em kb)";
$l['cfg-avatar_width']		= "Largura máxima para avatars enviados";
$l['cfg-avatar_height']		= "Altura máxima para avatars enviados";
$l['cfg-avatar_types']		= "Extensões válidas para avatars (seperar com vírgula):";

// site config fields, will be outputed *after* editing
$l['site-cfg-field-validate_email']	= "Validar e-mails";
$l['site-cfg-field-lang']			= "Arquivo de Idioma";
$l['site-cfg-field-site_name']		= "Nome do Website";
$l['site-cfg-field-news_date_format']	= "Formato da Data: Novidades";
$l['site-cfg-field-news_per_page']	= "Novidades por página";
$l['site-cfg-field-login_time']		= "Tempo a permanecer logado";
$l['site-cfg-field-art_date_view']	= "Formato da Data: Visualizar Artigo";
$l['site-cfg-field-art_date_list']	= "Formato da Data: Lista Artigos";
$l['site-cfg-field-memlist_per_page']	= "Nomes por página na lista de membros";
$l['site-cfg-field-memlist_date_format']	= "Formato da Data: Memberlist";
$l['site-cfg-field-server_timezone']	= "Fuso-horário do Servidor";
$l['site-cfg-field-recent_blog_num']	= "Número de blogs recentes";
$l['site-cfg-field-recent_blog_date']	= "Formato da Data: Blogs Recentes";
$l['site-cfg-field-default_date_format']	= "Formato da Data: Padrão";
$l['site-cfg-field-default_access']		= "Acesso padrão aos Usuários";
$l['site-cfg-field-home_text']			= "Texto no lugar de %HOME%";
$l['site-cfg-field-moods']				= "Lista de Estados";
$l['site-cfg-field-comment_date_format']	= "Formato da Data: Comentários";
$l['site-cfg-field-avatar_size']	= "Tamanho do arquivo de Avatar";
$l['site-cfg-field-avatar_width']	= "Largura do Avatar";
$l['site-cfg-field-avatar_height']	= "Altura do Avatar";
$l['site-cfg-field-avatar_types']	= "Arquivos de Avatar";

// edit user:
$l['edit-user-username']			= "Nome:";
$l['edit-user-email']				= "E-mail: ";
$l['edit-user-blog_count']			= "Blog Nº:";
$l['edit-user-timezone']			= "Fuso-horário: ";
$l['edit-user-bio']					= "Resumo:";
$l['edit-user-access']				= "Direitos de Acesso";
$l['edit-user-custom']				= "Campo ALternativo:";

// Mail Config
$l['cfg-mail-mail_type']			= "Tipo de Servidor: <br>(SMTP, SMPT-Auth, mail, sendmail, ou nenhum para disabilitar)";
$l['cfg-mail-smtp_username']		= "Nome no SMTP: <br>(if SMTP-Auth)";
$l['cfg-mail-smtp_password']		= "Senha no SMTP: <br>(if SMTP-Auth)";
$l['cfg-mail-smtp_host']			= "SMTP Host";
$l['cfg-mail-mail_from']			= "Endereço de Resposta para e-mails enviados (necessário)";
$l['cfg-mail-sendmail_path']		= "Caminho do sendmail";

//
// Misc
// ---------------------------------------------------

$l['no-friends']			= "Este usuário não adicionou nenhum amigo ainda.";
// gender
$l['gender-male']			= "Masculino";
$l['gender-female']			= "Feminino";
$l['gender-na']				= "Não Informado";
// bb codes
$l['bb-bold']				= "Negrito";
$l['bb-italic']				= "Itálico";
$l['bb-underline']			= "Sublinhado";
$l['bb-code']				= "Código fonte";
$l['bb-img']				= "Enviar imagem";
$l['bb-url']				= "Linkar para outra página";
$l['bb-quote']				= "Citar texto";
// admin edit text for editing comments
$l['admin-edit']			= "[editar]";
// what a banned use sees:
$l['banned_msg']			= "Você foi banido por este motivo: <b>%REASON%</b> <br>
You may return on %DATE%";

//
// Login.php
// ---------------------------------------------------

$l['log-bad-user']			= "Usuário não existe";
$l['log-bad-pass']			= "Senha inválida";
$l['log-good']				= "Você entrou no sistema";
$l['log-forgot']			= "Esqueceu sua senha?";
$l['log-out']				= "Você saiu no sistema.";
$l['log-check-email']		= "Esta conta ainda não foi validada. Verifique seu e-mail.";

//
// usercp.php
// ---------------------------------------------------

$l['ucp-subject']			= "Assunto: ";
$l['ucp-blog']				= "Blog: <br>(necessário)";
$l['ucp-insert']			= "Inserir...";
$l['ucp-ins-bbcode']		= "BB Code";
$l['ucp-ins-smiles']		= "Smiles";
$l['ucp-moodlist']			= "Selecione seu humor: ";
$l['ucp-mood']				= "Humor alternativo: ";
$l['ucp-access']			= "Acesso: ";
$l['ucp-options']			= "Opções: ";
$l['ucp-opt-bb']			= "Disabilitar BB Code";
$l['ucp-opt-html']			= "Disabilitar HTML";
$l['ucp-opt-smiles']		= "Disabilitar Smileys";
$l['ucp-opt-comments']		= "Disabilitar Comentários";
$l['ucp-null-mood']			= "-- Nenhum --";
$l['ucp-new-blog']			= "Seu post foi adicionado ao banco de dados.";
$l['ucp-choose-template']	= "
<p>
	<b>Template do Blog</b><br>
	Este template controla a aparência do seu blog. Ele controla tanto 
	um blog individual com comentários, quanto a página dos blogs.
</p>

<p>
	<b>Template dos Amigos</b><br>
	Este determina como os blogs postados por seus amigos vai se parecer.
</p>

<p>
	<b>Template do Perfil</b><br>
	A aparência das informações pessoais que você quer que sejam públicas
	é controlada por este template
</p>
" . '
<a href="%BLOG%">Editar Template do Blog</a><br>
<a href="%FRIENDS%">Editar Template dos Amigos</a><br>
<a href="%PROFILE%">Editar Template do Perfil</a>';
$l['ucp-tpl-edit-blog']		= "Editar Template do Blog:";
$l['ucp-tpl-edit-friends']	= "Editar Template dos Amigos:";
$l['ucp-tpl-edit-profile']	= "Editar Template do Perfil:";
$l['ucp-tpl-change']		= "<p><b>Template Padrão</b><br>
Você pode alterar o Template padrão que define a aparência
 de seus blogs, perfil, e página de amigos:</p>";
$l['ucp-revalidate']		= "Seu endereço de e-mail deve ser 
revalidado. Verifique seu e-mail logo. <b>Você está saindo do site...</b>";
$l['ucp-fri-exists']		= "Você já tem este usuário como amigo";
$l['ucp-fri-badname']		= "Usuário não existe";
$l['ucp-fri-addfriend']		= "Adicionar um amigo: ";
$l['ucp-fri-friend']		= "Amigo";
$l['ucp-fri-profile']		= "Ver Perfil";
$l['ucp-fri-blog']			= "Ler Blogs";
$l['ucp-fri-added']			= "Adicionado";
$l['ucp-fri-asfriend']		= "Usuários que tem você em suas listas de amigos";
$l['ucp-fri-yourfriends']	= "Seus Amigos";
$l['ucp-fri-del']			= "Apagar";
$l['ucp-view-blogs']		= '%USER%, você postou %PUBLIC% blogs públicos, 
e %PRIVATE% particulares. Clique <a href="%LINK%">aqui</a> para ver.';
$l['ucp-av-type-1']	= "Padrão";
$l['ucp-av-type-2']	= "Amigos";
$l['ucp-av-type-3']	= "Comentário";
$l['ucp-av-describe-types']	= "Sobre os diferentes tipos de Avatar:<br>
<b>Padrão</b>: Mostrado no seu perfil. <br>
<b>Amigos</b>: Mostrado na página dos amigos. <br>
<b>Comentários</b>: Mostrado nos seus comentários";
$l['ucp-av-restrict']			= "Restrições do Avatar:
Avatars devem ter no máximo %HEIGHT%px de altura, %WIDTH%px de largura, e %SIZE%kb.";
$l['ucp-av-type']			= "Tipo";
$l['ucp-av-image']			= "Imagem";
$l['ucp-av-none']			= "Nenhum avatar ainda<br>";
$l['ucp-av-add-default']	= "Use um avatar da galeria: ";
$l['ucp-av-upload']			= "Enviar seu próprio avatar:";
$l['ucp-av-upload-error']	= "Erro enviando: ";
$l['ucp-av-ecode-1']		= "Tamnho do arquivo muito grande";
$l['ucp-av-ecode-2']		= "Altura excedida";
$l['ucp-av-ecode-3']		= "Largura excedida";
$l['ucp-av-ecode-4']		= "Não é um formato válido";

//
// admincp.php
// ---------------------------------------------------

$l['acp-smiles']		 	= "Smileys";
$l['acp-addsmile']			= "Adicionar Smiley";
$l['acp-image']				= "Imagem";
$l['acp-code']				= "Emoção";
$l['acp-smile']				= "Smile";
$l['acp-smilefile']			= "Arquivo (localizado em /smiles)";
$l['acp-required']			= "Todos requeridos";
$l['acp-configchanged']		= "Você alterou os seguintes campos: ";
$l['acp-nochange']			= "Nenhuma alteração";
$l['acp-editnews']			= "Editar Novidades";
$l['acp-outter-tpl-info']	= '<b>Template Externo:</b><br>Este template pode ser usado para adicionar conteúdo externo aos templates dos usuários. <br>
{USER_TEMPLATE} Pode ser tanto o template do Blog, Amigos, ou Perfil. Você pode usar este template externo
para mostrar Adendos ou informações de copyright acima ou abaixo das páginas de usuários.<br>
Não modifique a parte {safe: } a menos que você saiba o que está fazendo.';
$l['acp-missing-smtp']		= "Por favor preencha todos os campos relacionados à SMTP";
$l['acp-mail-from']			= "Campo faltando: Endereço de Resposta";
$l['acp-smtp-host']			= "Faltando campo SMTP Host";
$l['acp-bad-mail-type']		= "Dados de e-mail inválidos";
$l['acp-no-email']			= "Seu site <b>não</b> pode enviar e-mails.";
$l['acp-article']			= "Artigo: ";
$l['acp-newarticle']		= "Novo artigo criado.";
$l['acp-ban-err-user']		= "Este usuário não existe";
$l['acp-ban-err-expires']	= "Formato de hora inválido";
$l['acp-ban-fld-name']		= "Banir Usuário";
$l['acp-ban-fld-reason']	= "Motivo";
$l['acp-ban-fld-until']		= "Tempo banido: <br>Formato:<br>10 dias<br>1 Ano";
$l['acp-ban-good']			= "Usuário foi banido";

//
// Email validation messages
// ---------------------------------------------------
$l['validate_failed']		= "A validação do e-mail <b>falhou</b>.";
$l['validate_good']			= "Validação do e-mail completada <b>com sucesso</b>. Você deve agora entrar no sistema.";
$l['validation_subject']	= "Validação de e-mail requerida";
$l['validation_email']		= <<< END_OF_EMAIL
%USER%,

Você precisa validar seu e-mail em %SITE%. Por favor, siga o link abaixo.

%LINK%

Muito obrigado,
Webmaster
END_OF_EMAIL;

?>