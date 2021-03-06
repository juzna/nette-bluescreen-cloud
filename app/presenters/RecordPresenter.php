<?php

/**
 * Add and process records.
 */
class RecordPresenter extends BasePresenter
{
	/** @var RecordService */
	private $recordService;



	public function renderDefault($hash)
	{
		$this->template->record = $record = $this->context->recordService->fetch($hash);
		if ( ! $record) throw new \Nette\Application\BadRequestException("Record not found", 404);
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
			$this->payload->id = $record->hash;
			$this->payload->link = $this->link("default", array($record->hash));
			$this->sendPayload();
		} else {
			$this->sendResponse(new Nette\Application\Responses\TextResponse("Added as $record->id"));
		}
	}

}
