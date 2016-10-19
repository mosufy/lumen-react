import React from 'react';
import Clearfix from './../../components/Clearfix.jsx';

export default class AddTodo extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h4>Add New TODOs</h4>
          <Clearfix/>
        </div>
      </div>
    );
  }
}
