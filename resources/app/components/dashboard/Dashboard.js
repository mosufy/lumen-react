import React from 'react';
import Clearfix from './../common/Clearfix';

export default class Dashboard extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h4>My TODOs</h4>
          <Clearfix/>
        </div>
      </div>
    );
  }
}
