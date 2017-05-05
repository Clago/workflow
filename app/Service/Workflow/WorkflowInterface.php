<?php
namespace Workflow;

interface WorkflowInterface{
	public function pass($process_id);

	public function unpass($proc_id);
}