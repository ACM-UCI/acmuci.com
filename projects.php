<?php
define('IN_SITE', true);
require 'common.php';
require 'header.php';

$incubator_projects = array();
$active_projects = array();

// Retrieve projects in incubation
$query = 'SELECT * FROM projects WHERE project_status=1';
$incubator_projects = $db->query($query);

// Retrieve active projects
$query = 'SELECT * FROM projects WHERE project_status=2';
$active_projects = $db->query($query);

if (isset($_POST['submit'])) {
	$errors = '';

	if (empty($errors)) {
		$query = 'INSERT INTO projects (project_status, project_name,
		project_contact_name, project_contact_email, project_desc) VALUES
		(:project_status, :project_name, :project_contact_name,
		:project_contact_email, :project_desc)';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':project_status', $project_status, PDO::PARAM_INT);
		$stmt->bindParam(':project_name', $project_name);
		$stmt->bindParam(':project_contact_name', $project_contact_name);
		$stmt->bindParam(':project_contact_email', $project_contact_email);
		$stmt->bindParam(':project_desc', $project_desc);
		$stmt->execute();
	}

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
			or simply contact the project manager, Gio Borje.</p>

			<h3>Benefits of a Project with ACM</h3>
			<ul>
				<li>Private GitHub Repository</li>
				<li>Private Redmine project</li>
			</ul>
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
							<dd><?= $incubator_project['project_contact_name']
							?></dd>
							<?php if
							(isset($incubator_project['project_contact_email'])):
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
				<form id="new-project" action="projects.php" method="POST">
					<p>
						<label for="name">Project Name</label><br />
						<input name="name" type="text"  required/>
					</p>
					<p>
						<label for="contact_name">Contact Name</label><br />
						<input name="contact_name" type="text" required/>
					</p>
					<p>
						<label for="contact_email">Contact Email</label><br />
						<input name="contact_email" type="email" required/>
					</p>
					<p>
						<label for="desc">Description</label><br />
						<textarea name="desc" required></textarea>
					</p>
					<p>
						<input type="submit" name="submit" value="Submit" />
					</p>
				</form>
			</div>

			<div id="projects-active">
				<h2>Active</h2>
				<?php foreach ($active_projects as $active_project): ?>
				<div class="project">
					<h3><?= $active_project['project_name'] ?></h3>
					<footer>
						<dl>
							<dt>Contact Name</dt>
							<dd><?= $active_project['project_contact_name']
							?></dd>
							<?php if
							(isset($active_project['project_contact_email'])):
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

<?php require 'footer.php'; ?>
