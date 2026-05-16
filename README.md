# Health Check Service

This monitors 3 services and exposes health metrics via API

The service currently monitors:
- Google
- Yahoo
- A simulated failing endpoint for testing error handling

Each health check returns:
- service status
- HTTP status code
- response time
- timestamp
- error messages when a service fails

# Sample Response

```json
{
  "overall_status": "degraded",
  "services": [
    {
      "service": "Google",
      "status": "up",
      "http_status": 200,
      "response_time": 1315.01
    },
    {
      "service": "Fake",
      "status": "down",
      "error": "Connection timeout"
    }
  ]
}
```

The application uses Laravel's HTTP client to send requests to configured endpoints.

A service is considered:
- UP when it responds successfully
- DOWN when the request fails, times out, or throws an exception

The overall system health is determined based on the combined status of all monitored services:
- healthy → all services are available
- degraded → one or more services are unavailable
- down → all services are unavailable
