/**
 * AppContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import App from './../components/App';

export default class AppContainer extends React.Component {
  render() {
    return (
      <App {...this.props}/>
    )
  }
}