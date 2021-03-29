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
      $this->assertSame(JobStatus::DRAFT, JobStatus::DRAFT());
      $this->assertSame(JobStatus::PENDING, JobStatus::PENDING());
      $this->assertSame(JobStatus::APPROVED, JobStatus::APPROVED());
    }

    /**
     * @test
     * @group Unit
     */
    public function testValuesAreCorrect()
    {
      $this->assertSame('DRAFT', JobStatus::DRAFT);
      $this->assertSame('PENDING', JobStatus::PENDING);
      $this->assertSame('APPROVED', JobStatus::APPROVED);
    }

    /**
     * @test
     * @group Unit
     */
    public function testCanGetAnIterableList()
    {
      $expected = [
        'DRAFT' => 'DRAFT',
        'PENDING' => 'PENDING',
        'APPROVED' => 'APPROVED',
      ];
      $this->assertSame($expected, JobStatus::all());
    }
}
