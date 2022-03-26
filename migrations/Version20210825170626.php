<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825170626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created constant table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE constant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE constant (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO constant (id, title, description) VALUES (1, \'CV\', \'
<h1 style="text-align:center">Marcin G&oacute;rski &ndash; Programista PHP</h1>

<div>
<p style="text-align:justify">Posiadam ponad trzyletnie doświadczenie jako programista PHP. Skupiam się na technologiach backendowych. Pracowałem gł&oacute;wnie nad framework&#39;iem Symfony.&nbsp;Chcę pracować przy projektach, gdzie będziemy dbać o jakość kodu.</p>

<p>&nbsp;</p>
</div>

<table border="0" cellpadding="0" cellspacing="5" style="width:900px">
	<tbody>
		<tr>
			<td style="width:300px"><strong>Telefon</strong></td>
			<td>609 214 544</td>
			<td rowspan="6"><img alt="Marcin Górski" src="https://mgorski.dev/img/marcin_gorski.png" style="float:right; height:225px; width:175px" /></td>
		</tr>
		<tr>
			<td><strong>E-mail</strong></td>
			<td><a href="mailto:gorskimarcin96@gmail.com">gorskimarcin96@gmail.com</a></td>
		</tr>
		<tr>
			<td><strong>Data urodzenia</strong></td>
			<td>07.10.1996</td>
		</tr>
		<tr>
			<td><strong>Miasto</strong></td>
			<td>Krasnystaw</td>
		</tr>
		<tr>
			<td><strong>Github</strong></td>
			<td><a href="https://github.com/gorskimarcin96">github.com/gorskimarcin96</a></td>
		</tr>
		<tr>
			<td><strong>WWW</strong></td>
			<td><a href="https://mgorski.dev/">mgorski.dev</a></td>
		</tr>
	</tbody>
</table>

<h2 style="text-align:center">Technologie i narzędzia</h2>

<table border="0" cellpadding="0" cellspacing="5" style="width:900px">
	<tbody>
		<tr>
			<td style="width:270px"><strong>Dobra znajomość</strong></td>
			<td>
			<ul>
				<li>backend: PHP, Symfony (1.4, 3-5), Laravel, PHPStorm, MySQL,&nbsp;ElasticSearch</li>
				<li>frontend:&nbsp;JavaScript, jQuery, ajax, CSS, Sass, Bootstrap (3-4)</li>
				<li>system kontroli wersji: Git</li>
			</ul>
			</td>
		</tr>
		<tr>
			<td><strong>Znajomość</strong></td>
			<td>
			<ul>
				<li>backend: PHPUnit, rabbitmq, redis</li>
				<li>frontend: Vue,&nbsp;puppeteer</li>
				<li>inne:&nbsp;Docker, Linux</li>
			</ul>
			</td>
		</tr>
		<tr>
			<td><strong>Podstawy</strong></td>
			<td>
			<ul>
				<li>frontend: angular 2+</li>
				<li>cms: Drupal 7,&nbsp;Drupal 8, WordPress</li>
			</ul>
			</td>
		</tr>
	</tbody>
</table>

<h2 style="text-align:center">Doświadczenie</h2>

<table border="0" cellpadding="0" cellspacing="5" style="width:900px">
	<tbody>
		<tr>
			<td style="width:270px"><strong>07.2021 &ndash; aktualnie</strong></td>
			<td>
			<p><strong>Świat kwiat&oacute;w- Programista PHP</strong></p>

			<p>Przenoszenie legacy code do symfony 5.</p>

			<p><span style="font-size:20px">Symfony 5, MySQL, docker, jira, elasticsearch, cscart, smarty, gitlab</span></p>
			</td>
		</tr>
		<tr>
			<td style="width:270px"><strong>10.2020 - 06.2021</strong></td>
			<td>
			<p><strong>Venusti - Programista PHP</strong></p>

			<p>Tworzenie aplikacji e-commarce do zmiany cen allegro. Obsługa integracji&nbsp;idosell.</p>

			<p><span style="font-size:20px">Laravel, MySQL, bitbucket, docker, goglobal, idosell, phpunit, bootstrap 4</span></p>
			</td>
		</tr>
		<tr>
			<td style="width:270px"><strong>11.2019 &ndash; 09.2020</strong></td>
			<td>
			<p><strong>Contelizer - Programista PHP</strong></p>

			<p>Serwisowanie/tworzenie moduł&oacute;w w aplikacji internetowej e-commarce do zarządzania aukcjami.</p>

			<p><span style="font-size:20px">Symfony 3, MySQL, jQuery, ajax, css, bootstrap 3, api, gitlab, allegro, baselinker, ifirma, infact</span></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td><strong>08.2018 &ndash; 10.2019</strong></td>
			<td>
			<p><strong>Webbit - Programista PHP</strong></p>

			<p>Tworzenie/serwisowanie stron oraz aplikacji internetowych - przetwarzanie danych.</p>

			<p><span style="font-size:20px">Symofny 1.4, Symofny 3,&nbsp;MySQL, api, bootstrap 3, bitbucket</span></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td><strong>02.2018 &ndash; 07.2018</strong></td>
			<td>
			<p><strong>Ftpstudio - Tworzenie stron www</strong></p>

			<p>Tworzenie stron internetowych z wykorzystaniem CMS.</p>

			<p><span style="font-size:20px">Drupal 7, Drupal 8</span></p>

			<p>&nbsp;</p>
			</td>
		</tr>
	</tbody>
</table>

<h2 style="text-align:center">Wykształcenie</h2>

<table border="0" cellpadding="0" cellspacing="5" style="width:900px">
	<tbody>
		<tr>
			<td style="width:270px"><strong>2019 &ndash; 2021</strong></td>
			<td><strong>Politechnika Lubelska - Informatyka</strong>
			<div class="small">Poziom wykształcenia: magister</div>

			<div class="small-2">Specjalizacja - tworzenie aplikacji internetowych</div>

			<div class="small-2">&nbsp;</div>
			</td>
		</tr>
		<tr>
			<td><strong>2015 &ndash; 2019</strong></td>
			<td><strong>Politechnika Lubelska - Informatyka</strong>
			<div class="small">Poziom wykształcenia: inżynier</div>
			</td>
		</tr>
	</tbody>
</table>

<h2 style="text-align:center">Języki obce</h2>

<p><strong>Język angielski:</strong> Umożliwiający czytanie dokumentacji technicznej.</p>

<h2 style="text-align:center">Hobby</h2>

<p>Tworzenie aplikacji internetowych. Jazda na rowerze.</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p style="text-align:justify"><span style="font-size:16px">Wyrażam zgodę na przetwarzanie danych osobowych zawartych w niniejszym dokumencie do realizacji procesu rekrutacji zgodnie z ustawą z dnia 10 maja 2018 roku o ochronie danych osobowych (Dz. Ustaw z 2018, poz. 1000) oraz zgodnie z Rozporządzeniem Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony os&oacute;b fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (RODO).</span></p>
\');');
        $this->addSql('INSERT INTO constant (id, title, description) VALUES (2, \'CV_DRAFT\', \'\');');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE constant_id_seq CASCADE');
        $this->addSql('DROP TABLE constant');
    }
}
