<?php

namespace Combodo\iTop\Test\UnitTest\Service;

use Combodo\iTop\Service\EventData;
use Combodo\iTop\Service\EventService;
use Combodo\iTop\Test\UnitTest\ItopTestCase;
use ContextTag;
use TypeError;

/**
 * Class EventTest
 *
 * @package Combodo\iTop\Test\UnitTest\Service
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 * @backupGlobals disabled
 */
class EventTest extends ItopTestCase
{
	const USE_TRANSACTION = false;
	const CREATE_TEST_ORG = false;

	private static $iEventCalls;

	protected function setUp()
	{
		parent::setUp();
		self::$iEventCalls = 0;
	}

	/**
	 * @dataProvider BadCallbackProvider
	 *
	 * @param $callback
	 *
	 * @throws \Exception
	 */
	public function testRegisterBadCallback($callback)
	{
		$this->expectException(TypeError::class);
		EventService::RegisterListener('event', $callback);
	}

	public function BadCallbackProvider()
	{
		return array(
			array('toto'),
			array('EventTest::toto'),
			array(array('EventTest', 'toto')),
			array(array($this, 'toto')),
		);
	}

	public function testNoParameterCallbackFunction()
	{
		$sId = EventService::RegisterListener('event', function () { $this->debug("Closure: event received !!!"); self::IncrementCallCount(); });
		$this->debug("Registered $sId");
		EventService::FireEvent(new EventData('event'));
		$this->assertEquals(1, self::$iEventCalls);
	}

	/**
	 * @dataProvider GoodCallbackProvider
	 *
	 * @param $callback
	 *
	 * @throws \Exception
	 */
	public function testMethodCallbackFunction(callable $callback)
	{
		$sId = EventService::RegisterListener('event', $callback);
		$this->debug("Registered $sId");
		EventService::FireEvent(new EventData('event'));
		$this->assertEquals(1, self::$iEventCalls);
		EventService::FireEvent(new EventData('event'));
		$this->assertEquals(2, self::$iEventCalls);
	}

	public function GoodCallbackProvider()
	{
		$oReceiver = new TestEventReceiver();
		return array(
			'method' => array(array($oReceiver, 'OnEvent1')),
			'static' => array('Combodo\iTop\Test\UnitTest\Service\TestEventReceiver::OnStaticEvent1'),
			'static2' => array(array('Combodo\iTop\Test\UnitTest\Service\TestEventReceiver', 'OnStaticEvent1')),
		);
	}

	public function testBrokenCallback()
	{
		$oReceiver = new TestEventReceiver();
		EventService::RegisterListener('event_a', array($oReceiver, 'BrokenCallback'));

		$this->expectException(TypeError::class);
		EventService::FireEvent(new EventData('event_a'));
	}

	public function testRemovedCallback()
	{
		$oReceiver = new TestEventReceiver();
		EventService::RegisterListener('event_a', array($oReceiver, 'OnEvent1'));

		$oReceiver = null;
		gc_collect_cycles();

		EventService::FireEvent(new EventData('event_a'));
		$this->assertEquals(1, self::$iEventCalls);
	}

	public function testMultiEvent()
	{
		$oReceiver = new TestEventReceiver();
		EventService::RegisterListener('event_a', array($oReceiver, 'OnEvent1'));
		EventService::RegisterListener('event_a', array($oReceiver, 'OnEvent2'));
		EventService::RegisterListener('event_a', array('Combodo\iTop\Test\UnitTest\Service\TestEventReceiver', 'OnStaticEvent1'));
		EventService::RegisterListener('event_a', 'Combodo\iTop\Test\UnitTest\Service\TestEventReceiver::OnStaticEvent2');

		EventService::RegisterListener('event_b', array($oReceiver, 'OnEvent1'));
		EventService::RegisterListener('event_b', array($oReceiver, 'OnEvent2'));
		EventService::RegisterListener('event_b', array('Combodo\iTop\Test\UnitTest\Service\TestEventReceiver', 'OnStaticEvent1'));
		EventService::RegisterListener('event_b', 'Combodo\iTop\Test\UnitTest\Service\TestEventReceiver::OnStaticEvent2');

		EventService::FireEvent(new EventData('event_a'));
		$this->assertEquals(4, self::$iEventCalls);
		EventService::FireEvent(new EventData('event_b'));
		$this->assertEquals(8, self::$iEventCalls);
	}

	public function testMultiSameEvent()
	{
		$oReceiver = new TestEventReceiver();
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");

		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(4, self::$iEventCalls);
	}

	public function testData()
	{
		$oReceiver = new TestEventReceiver();
		EventService::RegisterListener('event1', [$oReceiver, 'OnEventWithData'], '');
		EventService::RegisterListener('event1', [$oReceiver, 'OnEventWithData'], '');
		EventService::FireEvent(new EventData('event1', '', ['text' => 'Event Data 1']));
		$this->assertEquals(2, self::$iEventCalls);
	}

	public function testPriority()
	{
		$oReceiver = new TestEventReceiver();
		EventService::RegisterListener('event1', [$oReceiver, 'OnEvent1'], '', null, null, 0);
		EventService::RegisterListener('event1', [$oReceiver, 'OnEvent2'], '', null, null, 1);

		EventService::RegisterListener('event2', [$oReceiver, 'OnEvent1'], '', null, null, 1);
		EventService::RegisterListener('event2', [$oReceiver, 'OnEvent2'], '', null, null, 0);

		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(2, self::$iEventCalls);
		EventService::FireEvent(new EventData('event2'));
		$this->assertEquals(4, self::$iEventCalls);
	}

	public function testContext()
	{
		$oReceiver = new TestEventReceiver();
		EventService::RegisterListener('event1', [$oReceiver, 'OnEvent1'], '', null, null, 0);
		EventService::RegisterListener('event1', [$oReceiver, 'OnEvent2'], '', null, 'test_context', 1);
		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(1, self::$iEventCalls);
		ContextTag::AddContext('test_context');
		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(3, self::$iEventCalls);
	}

	public function testEventSource()
	{
		$oReceiver = new TestEventReceiver();
		EventService::RegisterListener('event1', [$oReceiver, 'OnEvent1'], 'A', null, null, 0);
		EventService::RegisterListener('event1', [$oReceiver, 'OnEvent2'], 'A', null, null, 1);
		EventService::RegisterListener('event1', 'Combodo\iTop\Test\UnitTest\Service\TestEventReceiver::OnStaticEvent1', null, null, null, 2);

		EventService::RegisterListener('event2', [$oReceiver, 'OnEvent1'], 'A', null, null, 1);
		EventService::RegisterListener('event2', 'Combodo\iTop\Test\UnitTest\Service\TestEventReceiver::OnStaticEvent1', null, null, null, 2);
		EventService::RegisterListener('event2', [$oReceiver, 'OnEvent2'], 'B', null, null, 0);

		EventService::FireEvent(new EventData('event1', 'A'));
		$this->assertEquals(3, self::$iEventCalls);
		EventService::FireEvent(new EventData('event2', 'A'));
		$this->assertEquals(5, self::$iEventCalls);
		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(6, self::$iEventCalls);
		EventService::FireEvent(new EventData('event2'));
		$this->assertEquals(7, self::$iEventCalls);
		EventService::FireEvent(new EventData('event2', ['A', 'B']));
		$this->assertEquals(10, self::$iEventCalls);

	}


	public function testUnRegisterEvent()
	{
		$oReceiver = new TestEventReceiver();
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event2', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");

		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(3, self::$iEventCalls);

		EventService::FireEvent(new EventData('event2'));
		$this->assertEquals(4, self::$iEventCalls);

		EventService::UnRegisterEvent('event1');

		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(4, self::$iEventCalls);

		EventService::FireEvent(new EventData('event2'));
		$this->assertEquals(5, self::$iEventCalls);
	}

	public function testUnRegisterAll()
	{
		$oReceiver = new TestEventReceiver();
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event2', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");

		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(3, self::$iEventCalls);

		EventService::FireEvent(new EventData('event2'));
		$this->assertEquals(4, self::$iEventCalls);

		EventService::UnRegisterAll();

		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(4, self::$iEventCalls);

		EventService::FireEvent(new EventData('event2'));
		$this->assertEquals(4, self::$iEventCalls);
	}

	public function testUnRegisterCallback()
	{
		$oReceiver = new TestEventReceiver();
		$sIdToRemove = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sIdToRemove");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event1', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");
		$sId = EventService::RegisterListener('event2', array($oReceiver, 'OnEvent1'));
		$this->debug("Registered $sId");

		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(3, self::$iEventCalls);

		EventService::FireEvent(new EventData('event2'));
		$this->assertEquals(4, self::$iEventCalls);

		EventService::UnRegisterCallback($sIdToRemove);

		EventService::FireEvent(new EventData('event1'));
		$this->assertEquals(6, self::$iEventCalls);

		EventService::FireEvent(new EventData('event2'));
		$this->assertEquals(7, self::$iEventCalls);
	}

	public static function IncrementCallCount()
	{
		self::$iEventCalls++;
	}

	/**
	 * static version of the debug to be accessible from other objects
	 *
	 * @param $sMsg
	 */
	public static function DebugStatic($sMsg)
	{
		if (DEBUG_UNIT_TEST)
		{
			if (is_string($sMsg))
			{
				echo "$sMsg\n";
			}
			else
			{
				print_r($sMsg);
			}
		}
	}
}

class TestEventReceiver
{

	// Event callbacks
	public function OnEvent1(EventData $oData)
	{
		$sEvent = $oData->GetEvent();
		$this->Debug(__METHOD__.": received event '{$sEvent}'");
		EventTest::IncrementCallCount();
	}

	// Event callbacks
	public function BrokenCallback(array $aData)
	{
		$sEvent = $aData['event'];
		$this->Debug(__METHOD__.": received event '{$sEvent}'");
		EventTest::IncrementCallCount();
	}

	// Event callbacks
	public function OnEvent2(EventData $oData)
	{
		$sEvent = $oData->GetEvent();
		$this->Debug(__METHOD__.": received event '{$sEvent}'");
		EventTest::IncrementCallCount();
	}

	public function OnEventWithData(EventData $oData)
	{
		$sEvent = $oData->GetEvent();
		$mEventData = $oData->GetEventData();
		$this->Debug(__METHOD__.": received event '{$sEvent}'");
		EventTest::IncrementCallCount();
		$this->Debug($mEventData);
	}

	// Event callbacks
	public static function OnStaticEvent1(EventData $oData)
	{
		$sEvent = $oData->GetEvent();
		self::DebugStatic(__METHOD__.": received event '{$sEvent}'");
		EventTest::IncrementCallCount();
	}

	// Event callbacks
	public static function OnStaticEvent2(EventData $oData)
	{
		$sEvent = $oData->GetEvent();
		self::DebugStatic(__METHOD__.": received event '{$sEvent}'");
		EventTest::IncrementCallCount();
	}

	/**
	 * static version of the debug to be accessible from other objects
	 *
	 * @param $sMsg
	 */
	public static function DebugStatic($sMsg)
	{
		if (DEBUG_UNIT_TEST)
		{
			if (is_string($sMsg))
			{
				echo "$sMsg\n";
			}
			else
			{
				print_r($sMsg);
			}
		}
	}
	/**
	 * static version of the debug to be accessible from other objects
	 *
	 * @param $sMsg
	 */
	public function Debug($sMsg)
	{
		if (DEBUG_UNIT_TEST)
		{
			if (is_string($sMsg))
			{
				echo "$sMsg\n";
			}
			else
			{
				print_r($sMsg);
			}
		}
	}

}