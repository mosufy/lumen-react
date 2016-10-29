/**
 * MyTodoVisibilityFilterLink
 *
 * @date 24/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';

export default class MyTodoVisibilityFilterLink extends React.Component {
  render() {
    var visibilityFilter = this.props.visibilityFilter;
    var currentFilter = this.props.filter;
    var btnStyle = 'btn btn-default btn-sm';
    var btnClick = this.props.setVisibilityFilter;

    if (currentFilter == visibilityFilter) {
      btnClick = '';
      if (currentFilter == 'SHOW_ALL') {
        btnStyle = 'btn btn-primary btn-sm';
      } else if (currentFilter == 'SHOW_ACTIVE') {
        btnStyle = 'btn btn-danger btn-sm';
      } else if (currentFilter == 'SHOW_COMPLETED') {
        btnStyle = 'btn btn-success btn-sm';
      }
    }

    return (
      <button id={currentFilter} type="button" className={btnStyle} onClick={btnClick}>{this.props.children}</button>
    );
  }
}