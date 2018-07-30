<?php

namespace EthicalJobs\SDK\Testing;

use EthicalJobs\SDK\Collection;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\json_decode;

/**
 * Api response factory
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ResponseFactory
{
	/**
	 * Token response
	 *
	 * @return String
	 */
	public static function token(): string
	{
		return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjZkMWY1NzhkNDFjZTg3ZTNmMDMzZDE1M2VmYmYzM2EzYmUzMjNjMzgyM2I2MmQ1YjVmOWFlOWU1ODk5YTA0NTZkZDUyMzI4ZGY5ZDg0NjU5In0';
	}

	/**
	 * Authentication response
	 *
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function authentication()
	{
		$response = json_decode('
			{
				"token_type": "Bearer",
				"expires_in": 31536000,
				"access_token": "'.static::token().'"
			}
		', true);

		return new Collection($response);
	}


	/**
	 * User resource response
	 *
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function user()
	{
		$response = json_decode('
			{
			  "data": {
			    "entities": {
			      "users": {
			        "5151": {
			          "id": 5151,
			          "organisation_id": 4943,
			          "first_name": "Michael",
			          "last_name": "Cebon",
			          "full_name": "Michael Cebon",
			          "bio": " ",
			          "avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/andrew-mclagan-avatar.jpg",
			          "email": "michael@ethicaljobs.com.au",
			          "username": "andrewmclagan",
			          "phone": null,
			          "position": "Founder & CEO",
			          "roles": [
			            "admin",
			            "staff-member",
			            "employer-member"
			          ],
			          "last_login": 1519587504000,
			          "created_at": 1471960800000,
			          "updated_at": 1524115239000
			        }
			      },
			      "organisations": {
			        "4943": {
			          "id": 4943,
			          "owner_id": 5152,
			          "admin_id": 0,
			          "uid": "EthicalJobs",
			          "name": "EthicalJobs.com.au",
			          "logo_url": "//d27jjb85n91zzw.cloudfront.net/media/1494829150_331hc_.jpeg",
			          "paid_staff": 0,
			          "volunteers": 0,
			          "phone": "03 9419 7322",
			          "address": "PO Box 2618",
			          "suburb": "Fitzroy",
			          "state": "Victoria",
			          "postcode": "3065",
			          "country": "AU",
			          "credit_balance": 176,
			          "invoice_count": 9,
			          "pending_job_count": 0,
			          "approved_job_count": 0,
			          "expired_job_count": 112,
			          "created_at": 1251258512000,
			          "updated_at": 1481595840000,
			          "deleted_at": null
			        }
			      }
			    },
			    "result": 5151
			  }
			}
		', true);

		return new Collection($response);
	}			


	/**
	 * Job resource response
	 *
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function job()
	{
		$string = file_get_contents(__DIR__.'/responses/job.json');

		$response = json_decode($string, true);

		return new Collection($response);
	}		

	/**
	 * Jobs resource response
	 *
	 * @param int $status
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function jobs()
	{
		$response = json_decode('
			{
			  "data": {
			    "entities": {
			      "jobs": {
			        "97954": {
			          "_score": null,
			          "id": 97954,
			          "organisation_id": 4247,
			          "organisation_uid": "MarrickvilleLC",
			          "status": "PENDING",
			          "title": "Paralegal",
			          "locked": false,
			          "locked_by_avatar": "",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            3
			          ],
			          "created_at": 1518420833000
			        },
			        "97953": {
			          "_score": null,
			          "id": 97953,
			          "organisation_id": 3061,
			          "organisation_uid": "EACHBigSplash",
			          "status": "PENDING",
			          "title": "Mental Health Clinician - Psychological Strategies Team",
			          "locked": false,
			          "locked_by_avatar": "",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            1
			          ],
			          "created_at": 1518418252000
			        },
			        "97952": {
			          "_score": null,
			          "id": 97952,
			          "organisation_id": 7471,
			          "organisation_uid": "TITEB",
			          "status": "PENDING",
			          "title": "Human Resource Officer",
			          "locked": false,
			          "locked_by_avatar": "",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            13
			          ],
			          "created_at": 1518417801000
			        },
			        "97951": {
			          "_score": null,
			          "id": 97951,
			          "organisation_id": 6338,
			          "organisation_uid": "BaptistcareWA",
			          "status": "PENDING",
			          "title": "Physiotherapist - Busselton",
			          "locked": false,
			          "locked_by_avatar": "",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            8
			          ],
			          "created_at": 1518416300000
			        },
			        "97925": {
			          "_score": null,
			          "id": 97925,
			          "organisation_id": 3319,
			          "organisation_uid": "APESMA",
			          "status": "PENDING",
			          "title": "Digital Campaigns Coordinator",
			          "locked": true,
			          "locked_by_avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/thao-du-avatar.jpg",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            1
			          ],
			          "created_at": 1518409839000
			        },
			        "97874": {
			          "_score": null,
			          "id": 97874,
			          "organisation_id": 7545,
			          "organisation_uid": "HallamCLC",
			          "status": "PENDING",
			          "title": "Manager",
			          "locked": true,
			          "locked_by_avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/alex-marsh-avatar.jpg",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            1
			          ],
			          "created_at": 1518390050000
			        },
			        "97821": {
			          "_score": null,
			          "id": 97821,
			          "organisation_id": 2054,
			          "organisation_uid": "Footprints",
			          "status": "PENDING",
			          "title": "Mental Health Professionals - Multiple positions",
			          "locked": true,
			          "locked_by_avatar": "https://www.gravatar.com/avatar/674d81ed54d84d1971ebb355a0f8c53f.jpg?s=200&d=mm",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            5
			          ],
			          "created_at": 1518151675000
			        },
			        "97763": {
			          "_score": null,
			          "id": 97763,
			          "organisation_id": 7540,
			          "organisation_uid": "Sancta Sophia College",
			          "status": "PENDING",
			          "title": "Marketing, Communications and Development Manager",
			          "locked": true,
			          "locked_by_avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/jessica-lawson-avatar.jpg",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            3
			          ],
			          "created_at": 1518141881000
			        },
			        "96765": {
			          "_score": null,
			          "id": 96765,
			          "organisation_id": 7534,
			          "organisation_uid": "PhysioInq",
			          "status": "PENDING",
			          "title": "Insane Support Co-ordinator",
			          "locked": true,
			          "locked_by_avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/thao-du-avatar.jpg",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            3
			          ],
			          "created_at": 1518068019000
			        },
			        "96692": {
			          "_score": null,
			          "id": 96692,
			          "organisation_id": 7527,
			          "organisation_uid": "Integrative Psychology",
			          "status": "PENDING",
			          "title": "Psychologist (Private Practice Contractor)",
			          "locked": true,
			          "locked_by_avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/jessica-lawson-avatar.jpg",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            1
			          ],
			          "created_at": 1518054816000
			        },
			        "96690": {
			          "_score": null,
			          "id": 96690,
			          "organisation_id": 7527,
			          "organisation_uid": "Integrative Psychology",
			          "status": "PENDING",
			          "title": "Receptionist",
			          "locked": true,
			          "locked_by_avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/jessica-lawson-avatar.jpg",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            1
			          ],
			          "created_at": 1518053890000
			        },
			        "96497": {
			          "_score": null,
			          "id": 96497,
			          "organisation_id": 7522,
			          "organisation_uid": "trish",
			          "status": "PENDING",
			          "title": "Administration Assistant",
			          "locked": true,
			          "locked_by_avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/alex-marsh-avatar.jpg",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            1
			          ],
			          "created_at": 1517894028000
			        },
			        "96000": {
			          "_score": null,
			          "id": 96000,
			          "organisation_id": 1966,
			          "organisation_uid": "CAA",
			          "status": "PENDING",
			          "title": "Marketing Intern",
			          "locked": true,
			          "locked_by_avatar": "https://s3-ap-southeast-2.amazonaws.com/ethical-jobs/statics/staff/alex-marsh-avatar.jpg",
			          "expired": false,
			          "views": 0,
			          "clicks": "N/A",
			          "locations": [
			            1
			          ],
			          "created_at": 1517383181000
			        }
			      }
			    },
			    "result": [
			      97954,
			      97953,
			      97952,
			      97951,
			      97925,
			      97874,
			      97821,
			      97763,
			      96765,
			      96692,
			      96690,
			      96497,
			      96000
			    ]
			  }
			}
		', true);

		return new Collection($response);
	}

	/**
	 * Jobs search resource response
	 *
	 * @param int $status
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function jobsSearch()
	{
		$string = file_get_contents(__DIR__.'/responses/search.jobs.json');

		$response = json_decode($string, true);

		return new Collection($response);
	}	


	/**
	 * Taxonomy request response
	 *
	 * @return  array
	 */
	public static function taxonomies()
	{
		$string = file_get_contents(__DIR__.'/responses/app.data.json');

		$response = json_decode($string, true);
        
		return new Collection($response);
	}	

	/**
	 * Mocks a response object with stream
	 * 
	 * @param int $status
	 * @param EthicalJobs\SDK\Collection $data
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function response(int $status, Collection $data): Response
	{
		$encoded = json_encode($data->toArray());

		$stream = \GuzzleHttp\Psr7\stream_for($encoded);

		$headers = ['Content-Type' => 'application/json'];

		return new Response($status, $headers, $stream);
	}	    
}