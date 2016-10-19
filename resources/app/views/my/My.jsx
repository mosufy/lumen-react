import React from 'react';
import Clearfix from './../../components/Clearfix.jsx';

export default class My extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h4>My current TODOs</h4>
          <Clearfix/>
        </div>
      </div>
    );
  }
}
