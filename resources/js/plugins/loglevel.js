import * as log from 'loglevel'
import { APP_ENV } from '~/constants'

window.log = log

if (APP_ENV && APP_ENV.toLowerCase() === 'production') {
  log.setDefaultLevel('silent')
} else {
  log.setDefaultLevel('trace')
}
