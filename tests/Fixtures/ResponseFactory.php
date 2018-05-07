<?php

namespace Tests\Fixtures;

use EthicalJobs\SDK\Collection;
use GuzzleHttp\Psr7\Response;

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
		$response = (array) json_decode('
			{
				"token_type": "Bearer",
				"expires_in": 31536000,
				"access_token": "'.static::token().'"
			}
		');

		return new Collection($response);
	}


	/**
	 * Job resource response
	 *
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function job()
	{
		$response = (array) json_decode('
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
			        }
			    },
			    "result": 97954
			  }
			}
		');

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
		$response = (array) json_decode('
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
		');

		return new Collection($response);
	}


    /**
     * Taxonomy request response
     *
     * @return  array
     */
    public static function taxonomies()
    {
        $response = (array) json_decode('
			{
			  "data": {
			    "taxonomies": {
			      "categories": {
			        "1": {
			          "id": 1,
			          "slug": "administration",
			          "title": "Administration",
			          "job_count": 128
			        },
			        "2": {
			          "id": 2,
			          "slug": "advocacy",
			          "title": "Advocacy and Campaigns",
			          "job_count": 50
			        },
			        "3": {
			          "id": 3,
			          "slug": "agedcare",
			          "title": "Aged Care and Seniors Rights",
			          "job_count": 42
			        },
			        "4": {
			          "id": 4,
			          "slug": "alcoholandotherdrugs",
			          "title": "Alcohol and Other Drugs",
			          "job_count": 59
			        },
			        "5": {
			          "id": 5,
			          "slug": "animalwelfareandprotection",
			          "title": "Animal Welfare and Protection",
			          "job_count": 16
			        },
			        "6": {
			          "id": 6,
			          "slug": "businessdevelopment",
			          "title": "Business Development and Sales",
			          "job_count": 57
			        },
			        "7": {
			          "id": 7,
			          "slug": "careandsupportservices",
			          "title": "Care and Support Work",
			          "job_count": 79
			        },
			        "8": {
			          "id": 8,
			          "slug": "coopsandcreditunions",
			          "title": "Co-ops and Credit Unions",
			          "job_count": 1
			        },
			        "9": {
			          "id": 9,
			          "slug": "communicationsandmarketing",
			          "title": "Communications and Marketing",
			          "job_count": 111
			        },
			        "10": {
			          "id": 10,
			          "slug": "communityanddevelopment",
			          "title": "Community Development",
			          "job_count": 87
			        },
			        "11": {
			          "id": 11,
			          "slug": "conservationandmanagement",
			          "title": "Conservation and Land Management",
			          "job_count": 23
			        },
			        "12": {
			          "id": 12,
			          "slug": "corporatesocialresponsibility",
			          "title": "Corporate Social Responsibility",
			          "job_count": 2
			        },
			        "13": {
			          "id": 13,
			          "slug": "disabilityservices",
			          "title": "Disability Services",
			          "job_count": 152
			        },
			        "14": {
			          "id": 14,
			          "slug": "earlychildhood",
			          "title": "Early Childhood",
			          "job_count": 35
			        },
			        "15": {
			          "id": 15,
			          "slug": "ecotourism",
			          "title": "Eco-Tourism",
			          "job_count": 2
			        },
			        "16": {
			          "id": 16,
			          "slug": "educationandtraining",
			          "title": "Education and Training",
			          "job_count": 126
			        },
			        "17": {
			          "id": 17,
			          "slug": "environmentandsustainability",
			          "title": "Environment and Sustainability",
			          "job_count": 50
			        },
			        "18": {
			          "id": 18,
			          "slug": "executiveseniormanagement",
			          "title": "Executive and Senior Management",
			          "job_count": 67
			        },
			        "19": {
			          "id": 19,
			          "slug": "familyservices",
			          "title": "Family Services",
			          "job_count": 208
			        },
			        "20": {
			          "id": 20,
			          "slug": "fairtradeorganicandecoretail",
			          "title": "FairTrade and Organic",
			          "job_count": 5
			        },
			        "21": {
			          "id": 21,
			          "slug": "financeandaccounting",
			          "title": "Finance and Accounting",
			          "job_count": 36
			        },
			        "22": {
			          "id": 22,
			          "slug": "fundraising",
			          "title": "Fundraising",
			          "job_count": 128
			        },
			        "23": {
			          "id": 23,
			          "slug": "glbt",
			          "title": "GLBTI and Sexual Health",
			          "job_count": 12
			        },
			        "24": {
			          "id": 24,
			          "slug": "greenarchitectureandproperty",
			          "title": "Green Architecture/Property",
			          "job_count": 0
			        },
			        "25": {
			          "id": 25,
			          "slug": "greenenergy",
			          "title": "Green Energy",
			          "job_count": 4
			        },
			        "26": {
			          "id": 26,
			          "slug": "greenproductsandservices",
			          "title": "Green Products and Services",
			          "job_count": 7
			        },
			        "27": {
			          "id": 27,
			          "slug": "healthcare",
			          "title": "Health Care and Allied Health",
			          "job_count": 163
			        },
			        "28": {
			          "id": 28,
			          "slug": "healthpromotion",
			          "title": "Health Promotion",
			          "job_count": 63
			        },
			        "29": {
			          "id": 29,
			          "slug": "housing",
			          "title": "Housing and Homelessness",
			          "job_count": 91
			        },
			        "30": {
			          "id": 30,
			          "slug": "customerservice",
			          "title": "Retail and Hospitality",
			          "job_count": 26
			        },
			        "31": {
			          "id": 31,
			          "slug": "hrandemploymentservices",
			          "title": "HR and Employment Services",
			          "job_count": 71
			        },
			        "32": {
			          "id": 32,
			          "slug": "indigenous",
			          "title": "Indigenous",
			          "job_count": 119
			        },
			        "33": {
			          "id": 33,
			          "slug": "internationalaidandevelopment",
			          "title": "International Aid and Development",
			          "job_count": 91
			        },
			        "34": {
			          "id": 34,
			          "slug": "itandcommunicationtechnology",
			          "title": "I.T. and Communication Technology",
			          "job_count": 28
			        },
			        "35": {
			          "id": 35,
			          "slug": "legalandhumanrights",
			          "title": "Legal and Human Rights",
			          "job_count": 63
			        },
			        "36": {
			          "id": 36,
			          "slug": "management",
			          "title": "Management",
			          "job_count": 258
			        },
			        "37": {
			          "id": 37,
			          "slug": "mediaartsandentertainment",
			          "title": "Media and Arts",
			          "job_count": 25
			        },
			        "38": {
			          "id": 38,
			          "slug": "medicalresearch",
			          "title": "Medical Research",
			          "job_count": 10
			        },
			        "39": {
			          "id": 39,
			          "slug": "mentalhealthandcounselling",
			          "title": "Mental Health and Counselling",
			          "job_count": 201
			        },
			        "40": {
			          "id": 40,
			          "slug": "multiculturalismdiversity",
			          "title": "Multiculturalism and Diversity",
			          "job_count": 57
			        },
			        "41": {
			          "id": 41,
			          "slug": "nursing",
			          "title": "Nursing",
			          "job_count": 40
			        },
			        "42": {
			          "id": 42,
			          "slug": "operationsriskmanagement",
			          "title": "Operations and Risk Management",
			          "job_count": 37
			        },
			        "43": {
			          "id": 43,
			          "slug": "organicfarmingandgardening",
			          "title": "Organic Farming and Gardening",
			          "job_count": 4
			        },
			        "44": {
			          "id": 44,
			          "slug": "policyandresearch",
			          "title": "Policy and Research",
			          "job_count": 66
			        },
			        "45": {
			          "id": 45,
			          "slug": "projectmanagement",
			          "title": "Project Management",
			          "job_count": 130
			        },
			        "46": {
			          "id": 46,
			          "slug": "recyclingandwastemanagement",
			          "title": "Recycling and Waste Management",
			          "job_count": 5
			        },
			        "47": {
			          "id": 47,
			          "slug": "socialwork",
			          "title": "Social Work",
			          "job_count": 289
			        },
			        "48": {
			          "id": 48,
			          "slug": "sustainabletransport",
			          "title": "Sustainable Transport",
			          "job_count": 4
			        },
			        "49": {
			          "id": 49,
			          "slug": "tradesandservices",
			          "title": "Trades and Services",
			          "job_count": 8
			        },
			        "50": {
			          "id": 50,
			          "slug": "unionsandworkersrights",
			          "title": "Unions and Workers Rights",
			          "job_count": 23
			        },
			        "51": {
			          "id": 51,
			          "slug": "volunteermanagement",
			          "title": "Volunteer Management",
			          "job_count": 24
			        },
			        "52": {
			          "id": 52,
			          "slug": "womensorganisationsandservices",
			          "title": "Womens Organisations and Services",
			          "job_count": 68
			        },
			        "53": {
			          "id": 53,
			          "slug": "youthservices",
			          "title": "Youth",
			          "job_count": 190
			        }
			      },
			      "locations": {
			        "1": {
			          "id": 1,
			          "slug": "VIC",
			          "title": "Melbourne"
			        },
			        "2": {
			          "id": 2,
			          "slug": "REGVIC",
			          "title": "Regional VIC"
			        },
			        "3": {
			          "id": 3,
			          "slug": "NSW",
			          "title": "Sydney"
			        },
			        "4": {
			          "id": 4,
			          "slug": "REGNSW",
			          "title": "Regional NSW"
			        },
			        "5": {
			          "id": 5,
			          "slug": "QLD",
			          "title": "Brisbane & Gold Coast"
			        },
			        "6": {
			          "id": 6,
			          "slug": "REGQLD",
			          "title": "Regional QLD"
			        },
			        "7": {
			          "id": 7,
			          "slug": "WA",
			          "title": "Perth"
			        },
			        "8": {
			          "id": 8,
			          "slug": "REGWA",
			          "title": "Regional WA"
			        },
			        "9": {
			          "id": 9,
			          "slug": "SA",
			          "title": "Adelaide"
			        },
			        "10": {
			          "id": 10,
			          "slug": "REGSA",
			          "title": "Regional SA"
			        },
			        "11": {
			          "id": 11,
			          "slug": "TAS",
			          "title": "Hobart"
			        },
			        "12": {
			          "id": 12,
			          "slug": "REGTAS",
			          "title": "Regional TAS"
			        },
			        "13": {
			          "id": 13,
			          "slug": "NT",
			          "title": "Darwin"
			        },
			        "14": {
			          "id": 14,
			          "slug": "REGNT",
			          "title": "Regional NT"
			        },
			        "15": {
			          "id": 15,
			          "slug": "ACT",
			          "title": "Canberra & ACT"
			        },
			        "16": {
			          "id": 16,
			          "slug": "AUSTRALIAWIDE",
			          "title": "Australia-Wide"
			        },
			        "17": {
			          "id": 17,
			          "slug": "INTERNATIONAL",
			          "title": "International"
			        }
			      },
			      "sectors": {
			        "1": {
			          "id": 1,
			          "slug": "Business and Private Sector",
			          "title": "Business/Private Sector"
			        },
			        "2": {
			          "id": 2,
			          "slug": "Federal Government",
			          "title": "Federal Government"
			        },
			        "3": {
			          "id": 3,
			          "slug": "Local Government",
			          "title": "Local Government"
			        },
			        "4": {
			          "id": 4,
			          "slug": "Not For Profit (NFP)",
			          "title": "Not For Profit (NFP)"
			        },
			        "5": {
			          "id": 5,
			          "slug": "socialenterprise",
			          "title": "Social Enterprise"
			        },
			        "6": {
			          "id": 6,
			          "slug": "State Government",
			          "title": "State Government"
			        },
			        "7": {
			          "id": 7,
			          "slug": "university",
			          "title": "University & Higher Education"
			        }
			      },
			      "workTypes": {
			        "1": {
			          "id": 1,
			          "slug": "CASUAL",
			          "title": "Casual"
			        },
			        "2": {
			          "id": 2,
			          "slug": "CONTRACT",
			          "title": "Contract"
			        },
			        "3": {
			          "id": 3,
			          "slug": "FULLTIME",
			          "title": "Full Time"
			        },
			        "4": {
			          "id": 4,
			          "slug": "GRADUATE",
			          "title": "Graduate"
			        },
			        "5": {
			          "id": 5,
			          "slug": "PARTTIME",
			          "title": "Part Time"
			        },
			        "6": {
			          "id": 6,
			          "slug": "VOLUNTEER",
			          "title": "Volunteer"
			        }
			      }
			    }
			  }
			}
		', true);

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