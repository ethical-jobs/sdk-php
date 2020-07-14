<?php

namespace Tests\Unit;

use EthicalJobs\SDK\Enumerables\JobStatus;
use Tests\TestCase;

class JobStatusTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function testFunctionOutputMatchesConst()
    {
      $this->assertEquals(JobStatus::DRAFT, JobStatus::DRAFT());
    }

    /**
     * @test
     * @group Unit
     */
    public function testCanItterateOverConst()
    {
      foreach(JobStatus::all() as $value) {
        $this->assertContains($value, JobStatus::allValues());
      }
    }
}
