	</main>

	<footer class="flex-shrink-0 text-muted small fw-bold bg-light py-3">
		<div class="container-lg d-flex flex-wrap justify-content-center align-items-center">
			<div>
				<span><?= $this->lang->line('common_copyrights', date('Y')); ?></span>
			</div>
			<div>
				<span class="d-none d-xl-block">&nbsp;·&nbsp;<a href="https://opensourcepos.org" class="text-muted" target="_blank" rel="noopener"><?= $this->lang->line('common_website'); ?></a>&nbsp;·&nbsp;</span>
				<span class="d-xl-none">&nbsp;·&nbsp;<?= $this->lang->line('common_website'); ?>&nbsp;·&nbsp;</span>
			</div>
			<div>
				<span class="d-none d-xl-block"><?= $this->config->item('application_version'); ?>&nbsp;-&nbsp;<a href="https://github.com/opensourcepos/opensourcepos/commit/<?= $this->config->item('commit_sha1'); ?>" class="text-muted" target="_blank" rel="noopener"><?= substr($this->config->item('commit_sha1'), 0, 6); ?></a></span>
				<span class="d-xl-none"><?= $this->config->item('application_version'); ?>&nbsp;-&nbsp;<?= substr($this->config->item('commit_sha1'), 0, 6); ?></span>
			</div>
		</div>
	</footer>

	<script src="dist/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="js/bs-tooltips.js"></script>

</body>

</html>