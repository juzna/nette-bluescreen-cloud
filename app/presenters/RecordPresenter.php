<?php

/**
 * Add and process records.
 */
class RecordPresenter extends BasePresenter
{
	/** @var RecordService */
	private $recordService;



	public function renderDefault($id)
	{
		$this->template->record = $record = $this->context->recordService->fetch($id);
	}



	public function actionAdd($message)
	{
		// Allow cross domain ajax
		$this->context->httpResponse->setHeader('Access-Control-Allow-Origin', '*');
		$this->context->httpResponse->setHeader('Access-Control-Allow-Methods', 'POST, GET');


		$record = $this->context->recordService->add($message, $this->context->httpRequest->getPost()['content']);
		if (true || $this->isAjax()) {
			$this->absoluteUrls = TRUE;
			$this->payload->ok = TRUE;
			$this->payload->id = $record->id;
			$this->payload->link = $this->link("default", array($record->id));
			$this->sendPayload();
		} else {
			$this->sendResponse(new Nette\Application\Responses\TextResponse("Added as $record->id"));
		}
	}

}
