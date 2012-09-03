<?php
define('IN_SITE', true);
require_once 'common.php';
require_once 'header.php';

include APP_MODELS . 'Project.php';

$incubator_projects = array();
$active_projects = array();

// Retrieve projects in incubation
$query = 'SELECT p.project_name, p.project_desc, 
	m.member_name as project_contact_name,
	m.member_link as project_contact_link,
	m.member_email as project_contact_email
	FROM projects as p
	LEFT JOIN members as m 
		ON p.project_contact_id = m.member_id
	WHERE project_status = 1';
$incubator_projects = $db->query($query);

// Retrieve active projects
$query = 'SELECT p.project_name, p.project_desc, 
	m.member_name as project_contact_name,
	m.member_link as project_contact_link,
	m.member_email as project_contact_email
	FROM projects as p
	LEFT JOIN members as m 
		ON p.project_contact_id = m.member_id
	WHERE project_status = 2';
$active_projects = $db->query($query);

if (isset($_POST['submit'])) {
	// Sanitize strings
	$project_name = filter_var($_POST['project_name'], FILTER_SANITIZE_STRING);
	$project_desc = filter_var($_POST['project_desc'], FILTER_SANITIZE_STRING);

	$project = new Project(PROJECT_PROPOSE, $project_name, $project_desc,
	$user_info['member_id']);
	$status = $project->create();	
}
?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<h2>Project Process</h2>
			<p>ACM follows a three-phase approach to establishing projects. 
			First, there is the <strong>Proposal phase</strong> where a 
			project idea is presented to the project manager for incubation
			approval.  Second, is the <strong>Incubation phase</strong> where
			the project idea is placed under discussion while potential
			developers commit to the project. Finally, the <strong>Active
			phase</strong> is where the project is under development.</p>

			<div class="spanner">
				<img src="images/project_tpa_small.png" title="Project
				Three-Phase Approach" />
			</div>

			<p>Each project has a contact whom can provide further details. If 
			contact information is not provided, please contact the current 
			project manager, Gio Borje for details about the project. If 
			instead, you wish to propose a project for ACM, use the form below 
			or simply contact the project manager, Gio Borje. All projects 
			with ACM receive several benefits including your choice of a 
			private GitHub repository or a private Redmine project.</p>
		</div>	
	</div>
</section>
<section id="secondary-content">
	<div class="inner">
		<div class="content-block">
			<div id="projects-incubator">
				<h2>Incubator</h2>
				<?php foreach ($incubator_projects as $incubator_project): ?>
				<div class="project">
					<h3><?= $incubator_project['project_name'] ?></h3>
					<footer>
						<dl>
							<dt>Contact Name</dt>
							<dd><a href="<?=
							$incubator_project['project_contact_link'] ?>"><?=
							$incubator_project['project_contact_name']
							?></a></dd>
							<?php if
							(!empty($incubator_project['project_contact_email'])):
							?>
							<dt>Contact Email</dt>
							<dd><?= $incubator_project['project_contact_email']
							?></dd>
							<?php endif; ?>
						</dl>
					</footer>
					<p><?= $incubator_project['project_desc'] ?></p>
				</div>
				<?php endforeach; ?>

				<h2>Project Proposal</h2>
				<?php if (!$user): ?>
				<p>Please <a href="<?= $login_url ?>">login</a> to propose a
				project.</p>
				<?php else: ?>
				<form id="new-project" action="projects.php" method="POST">
					<p>
						<label for="project_name">Project Name</label><br />
						<input name="project_name" type="text"  required/>
					</p>
					<p>
						<label for="project_desc">Description</label><br />
						<textarea name="project_desc" required></textarea>
					</p>
					<p>
						<input type="submit" name="submit" value="Submit" />
					</p>
				</form>
				<?php endif; ?>
			</div>

			<div id="projects-active">
				<h2>Active</h2>
				<?php foreach ($active_projects as $active_project): ?>
				<div class="project">
					<h3><?= $active_project['project_name'] ?></h3>
					<footer>
						<dl>
							<dt>Contact Name</dt>
							<dd>
								<a href="<?=
								$active_project['project_contact_link'] ?>"><?=
								$active_project['project_contact_name']
							?></a>
							</dd>
							<?php if
							(!empty($active_project['project_contact_email'])):
							?>
							<dt>Contact Email</dt>
							<dd><?= $active_project['project_contact_email']
							?></dd>
							<?php endif; ?>
						</dl>
					</footer>
					<p><?= $active_project['project_desc'] ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<?php require_once 'footer.php'; ?>
